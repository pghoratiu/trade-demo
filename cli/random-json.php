<?php
require_once __DIR__.'/../vendor/autoload.php';
$faker = Faker\Factory::create();

$data = [];
$allCurrencies = ['EUR' => 'EUR', 'RON' => 'RON', 'USD' => 'USD', 'GBP' => 'GBP'];
$data['userId'] = $faker->randomElement(array(100, 200));
$data['currencyFrom'] = $faker->randomElement($allCurrencies);
unset($allCurrencies[$data['currencyFrom']]);
$data['currencyTo'] = $faker->randomElement($allCurrencies);
$data['amountSell'] = $faker->randomFloat(4, 1, 1000);
$data['amountBuy'] = $faker->randomFloat(4, 1, 1000);
$data['rate'] = $faker->randomFloat(4, 0.0001, 10);
$data['timePlaced'] = $faker->dateTimeBetween($startDate = '-1 day', $endDate = 'now')
                            ->format('d-M-y H:i:s');
$data['originatingCountry'] = $faker->countryCode;
?>
{
  "userId": "<?php echo $data['userId'] ?>",
  "currencyFrom": "<?php echo $data['currencyFrom'] ?>",
  "currencyTo": "<?php echo $data['currencyTo'] ?>",
  "amountSell": <?php echo $data['amountSell'] ?>,
  "amountBuy": <?php echo $data['amountBuy'] ?>,
  "rate": <?php echo $data['rate'] ?>,
  "timePlaced" : "<?php echo $data['timePlaced'] ?>",
  "originatingCountry" : "<?php echo $data['originatingCountry'] ?>"
}
