<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once (__DIR__ . '/App/Config/routes.php');
require_once (__DIR__ . '/App/Config/storage.php');

use App\Application;
use App\Resources\Resource;

/** @var $connection */

try {
    $obj = new Application($connection, $GLOBALS['storage'], $_SERVER['REQUEST_URI']);
    echo $obj->controllerActionResult;
} catch (\Exception $exception) {
    $resource = new Resource;
    $resource->set([$exception->getMessage()], 404);
    echo $resource->response();
}
