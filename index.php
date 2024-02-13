<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once(__DIR__ . '/App/Config/routes.php');

error_reporting(0);

use App\Application;
use App\Resources\SubscribesResource;

/** @var $connection */

function exception_handler(Throwable $exception)
{
    $resource = new SubscribesResource;
    echo $resource->response([
        'success' => false,
        'message' => $exception->getMessage()
    ], $exception->getCode());
}

set_exception_handler('exception_handler');

$obj = new Application($connection, $_SERVER['REQUEST_URI']);
echo $obj->controllerActionResult;
