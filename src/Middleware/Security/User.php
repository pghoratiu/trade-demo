<?php

/**
 * Part of the middleware stack, does a dummy check for user id.
 * Any other security, rate limit, sanity check would be done on this level.
 */

namespace MyCode\Middleware\Security;

class User extends \Slim\Middleware
{
    public function __construct()
    {

    }

    public function call()
    {
        $key = $this->app->request()->getResourceUri();

        $this->app->log->addInfo('Middleware URI: '.$key, array('middleware' => 'user'));

        $rsp = $this->app->response();

        if ($key == '/process/trade-message') {
            $data = json_decode($this->app->request->getBody());
            if (isset($data->userId) && intval($data->userId) !== 100) {
                // Just stop - return an error to the caller
                $this->app->log->addWarning('Unauthorized user tried to initiate a transaction');

                $rsp["Content-Type"] = "application/json";
                $rsp->body('{"error":"300", "message":"User Forbidden"}');
                $rsp->setStatus(403);

                return;
            }
        }

        $this->next->call();
    }
}