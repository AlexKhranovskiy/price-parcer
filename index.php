<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/App/Config/database.php');
require_once(__DIR__ . '/App/Config/routes.php');
require_once(__DIR__ . '/App/Config/storage.php');

use App\Application;
use App\Resources\Resource;

/** @var $connection */

function friendlyErrorType($type)
{
    switch($type)
    {
        case E_ERROR: // 1 //
            return 'E_ERROR';
        case E_WARNING: // 2 //
            return 'E_WARNING';
        case E_PARSE: // 4 //
            return 'E_PARSE';
        case E_NOTICE: // 8 //
            return 'E_NOTICE';
        case E_CORE_ERROR: // 16 //
            return 'E_CORE_ERROR';
        case E_CORE_WARNING: // 32 //
            return 'E_CORE_WARNING';
        case E_COMPILE_ERROR: // 64 //
            return 'E_COMPILE_ERROR';
        case E_COMPILE_WARNING: // 128 //
            return 'E_COMPILE_WARNING';
        case E_USER_ERROR: // 256 //
            return 'E_USER_ERROR';
        case E_USER_WARNING: // 512 //
            return 'E_USER_WARNING';
        case E_USER_NOTICE: // 1024 //
            return 'E_USER_NOTICE';
        case E_STRICT: // 2048 //
            return 'E_STRICT';
        case E_RECOVERABLE_ERROR: // 4096 //
            return 'E_RECOVERABLE_ERROR';
        case E_DEPRECATED: // 8192 //
            return 'E_DEPRECATED';
        case E_USER_DEPRECATED: // 16384 //
            return 'E_USER_DEPRECATED';
    }
    return "";
}

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    $errstr = htmlspecialchars($errstr);
    $resource = new Resource;
    $resource->set([
        'errorno' => friendlyErrorType($errno),
        'errstr' => $errstr,
        'errfile' => $errfile,
        'errline' => $errline
    ], 500);
    echo $resource->response();
    //exit;
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