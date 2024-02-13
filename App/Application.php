<?php

namespace App;

use App\Controllers\Controller;
use App\Database\Database;
use App\Router\RouteBuilder;
use App\Router\Router;

class Application
{
    public array|string|null $controllerActionResult;

    /**
     * @throws \Exception
     */
    public function __construct(array $connection, string $uri)
    {
        $db = new Database($connection);
        $router = Router::run($uri);
        RouteBuilder::take()->run($router);
        $this->controllerActionResult = Controller::run(
            $router->resource,
            $router->id,
            $router->controllerAction,
            $router->queryParams,
            $router->controller,
            $db
        );
    }
}
