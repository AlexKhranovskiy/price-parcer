<?php


use App\Database\Database;
use App\Models\Subscription;
use App\Models\User;
use App\Services\AdService;
use App\Services\MailService;

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once(__DIR__ . '/App/Config/mail.php');

/** @var $connection */
/** @var $mailParams */

$db = new Database($connection);

$user = new User($db);
$subscription = new Subscription($db, $user);

$subscriptions = $subscription->getAllWithUsers();

$adService = new AdService();
$mailService = new MailService($mailParams);
foreach ($subscriptions as $key => $subscription) {
    $result = $adService->getSource($subscription['url'])->getPriceAndCurrencyCode();
    if ($result['price'] == $subscription['price']) {
        foreach (current($subscription['email']) as $email) {
            $mailService($email, $result['price'], $subscription['price'], $result['currencyCode'], $subscription['url']);
            echo 'Mail to: ' . $email . ' has sent' . PHP_EOL;
        }
    }
}