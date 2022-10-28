<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once(__DIR__ . '/App/Config/routes.php');
require_once(__DIR__ . '/App/Config/storage.php');

use App\Application;
use App\Resources\Resource;

/** @var $connection */

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
//    if (!(error_reporting() & $errno)) {
//        return false;
//    }
//    $errstr = htmlspecialchars($errstr);
//
//    switch ($errno) {
//        case E_USER_WARNING:
//            $resource = new Resource;
//            $resource->set([$errstr], 404);
//            echo $resource->response();
//            break;
//        default:
//            break;
//    }
//    return true;
}

set_error_handler("myErrorHandler");

function exception_handler(Throwable $exception)
{
    $resource = new Resource;
    $resource->set([$exception->getMessage()], $exception->getCode());
    echo $resource->response();
}
set_exception_handler('exception_handler');

$obj = new Application($connection, $GLOBALS['storage'], $_SERVER['REQUEST_URI']);
echo $obj->controllerActionResult;