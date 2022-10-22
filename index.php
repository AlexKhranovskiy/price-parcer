<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once (__DIR__ . '/App/Config/routes.php');
require_once (__DIR__ . '/App/Config/storage.php');

use App\Application;

/** @var $connection */
///** @var $storage */

$obj = new Application($connection, $GLOBALS['storage'], $_SERVER['REQUEST_URI']);

echo $obj->controllerActionResult;
