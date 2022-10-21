<?php

namespace App;

use App\Controllers\Controller;
use App\Database\Database;
use App\Models\Model;
use App\Router\Route;
use App\Router\Router;
use App\Views\Home;

class Application
{
    public array|string|null $controllerActionResult;
    /**
     * @throws \Exception
     */
    public function __construct(array $connection, string $storage, string $uri)
    {
        try {
            $db = new Database($connection);
            $router = Router::run($uri);
            Route::take()->run($router);
            Model::set($db, $storage);
            $this->controllerActionResult = Controller::run(
                $router->resource,
                $router->id,
                $router->controllerAction,
                $router->queryParams,
                $router->controller
            );
        } catch (\Exception $exception) {

        }
    }
}
