<?php
require __DIR__  . '/../vendor/autoload.php';

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->twigTemplateDirs = array(__DIR__.'/../src/templates');
$view->parserOptions = array(
    'debug' => true,
    'cache' => __DIR__.'/../cache'
);

$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new \MyCode\Twig\TwigExtension()
);

$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('web-app');
    $log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__.'/../log/log.txt'));
    return $log;
});

$app->container->singleton('db', function () {
    $cfg = new \Spot\Config();
    $cfg->addConnection("sqlite", [
        "path" => __DIR__."/../db/db2.sqlite",
        "driver" => "pdo_sqlite"
    ]);
    $spot = new \Spot\Locator($cfg);

    return $spot;
});


# Middleware - checks user id value is correct
$app->add(new \MyCode\Middleware\Security\User($app->log));

$app->post('/process/trade-message', function() use ($app) {

    $tmq = new \MyCode\Entity\TradeMessageQueue();
    $raw_request = $app->request->getBody();
    $tmq->id = hash("sha256", $raw_request);
    $tmq->body = $raw_request;

    $mapper = $app->db->mapper('MyCode\Entity\TradeMessageQueue');
    $mapper->save($tmq);
});

$app->get('/', function () use ($app){
    $app->render('homepage.twig');
});

$app->get('/transactions', function() use ($app){
   $mapper = $app->db->mapper('MyCode\Entity\TradeMessageQueue');
   $data = $mapper->mostRecentTransactions(5);

   $app->render('Transactions/list.twig', array('transactions' => $data));
});

$app->get('/db/reset', function () use ($app) {
    $mapper = $app->db->mapper('MyCode\Entity\TradeMessageQueue');

    # Empty trade_message_queue table
    $mapper->migrate();
    $mapper->truncateTable();

    $app->render('reset.twig');
});

$app->run();