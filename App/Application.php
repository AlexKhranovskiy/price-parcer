<?php

namespace App;

use App\Controllers\Controller;
use App\Database\Database;
use App\models\File;
use App\Router\Route;
use App\Router\Router;
use App\Services\FileManager;

class Application
{
    public array|string|null $controllerActionResult;

    /**
     * @throws \Exception
     */
    public function __construct(array $connection, string $storage, string $uri)
    {
        $db = new Database($connection);
        $router = Router::run($uri);
        Route::take()->run($router);
        $file = new File($db, $storage, new FileManager($_FILES));
        $this->controllerActionResult = Controller::run(
            $router->resource,
            $router->id,
            $router->controllerAction,
            $router->queryParams,
            $router->controller,
            $file
        );
    }
}
