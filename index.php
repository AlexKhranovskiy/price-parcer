<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once(__DIR__ . '/App/Config/routes.php');
require_once(__DIR__ . '/App/Config/storage.php');

error_reporting(0);

use App\Application;
use App\Resources\Resource;

/** @var $connection */

function exception_handler(Throwable $exception)
{
    $resource = new Resource;
    $resource->set([$exception->getMessage()], $exception->getCode());
    echo $resource->response();
}

set_exception_handler('exception_handler');

$obj = new Application($connection, $GLOBALS['storage'], $_SERVER['REQUEST_URI']);
echo $obj->controllerActionResult;
