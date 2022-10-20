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
    public function __construct(array $connection, string $uri)
    {
        try {
            $db = new Database($connection);
            $router = Router::run($uri);
            Route::take()->run($router);
            Model::run($db);
            $this->controllerActionResult = Controller::run(
                $router->resource,
                $router->id,
                $router->controllerAction,
                $router->queryParams,
                $router->controller
            );
        } catch (\Exception $exception) {
            $this->controllerActionResult =
                (new Home())->error([$exception->getMessage()], '/home', 'Home')
            ->render();
        }
    }
}
