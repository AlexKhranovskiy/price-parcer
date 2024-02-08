<?php

use App\Database\Database;
use App\Models\Model;
use App\Models\Subscription;
use App\Models\User;
use App\Services\AdService;

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once(__DIR__ . '/App/Config/routes.php');
require_once(__DIR__ . '/App/Config/storage.php');

/** @var $connection */

//$db = new Database($connection);
//
//$user = new User($db);
////$u = $user->AddNew('alex@ukr.net');
//$u = $user->getById(1);
//var_dump($u);
//
//$subscription = new Subscription($db, $user);
//$s = $subscription->addNew('https://link/1');
//$s = $subscription->attachToUser($user);
////$s = $subscription->addNew('https://link/1');
//var_dump($s);
//$url = 'https://www.olx.ua/d/uk/obyavlenie/kostyumi-zara-na-fls-dlya-dvchatok-dityacha-zara-IDTUnsE.html';
$s = new AdService();
var_dump($s->handle('https://www.olx.ua/d/uk/obyavlenie/prodam-3h-kom-kvartiru-na-kirova-IDUfizH.html'));
//$t = $s->handle('https://www.olx.ua/d/uk/obyavlenie/kostyumi-zara-na-fls-dlya-dvchatok-dityacha-zara-IDTUnsE.html');
//$r = str_replace('\\','',$t);
//var_dump(json_decode($t, true), json_last_error_msg());
//var_dump($t);
