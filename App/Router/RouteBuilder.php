<?php

namespace App\Router;

class RouteBuilder
{
    private static ?RouteBuilder $instance = null;
    private static array $GET = [];
    private static array $POST = [];
    private static array $PATCH = [];
    private static array $DELETE = [];

    public static function get(
        string $resource,
        string|null $action,
        string|null $controllerAction,
        string|null $controller = null
    ): void
    {
        self::$GET[] = [$resource, $action, $controllerAction, $controller];
        if (is_null(self::$instance)) {
            new self();
        }
    }

    public static function post(
        string $resource,
        string|null $action,
        string|null $controllerAction,
        string|null $controller = null
    ): void
    {
        self::$POST[] = [$resource, $action, $controllerAction, $controller];
        if (is_null(self::$instance)) {
            new self();
        }
    }

    public static function patch(
        string $resource,
        string|null $action,
        string|null $controllerAction,
        string|null $controller = null
    ): void
    {
        self::$PATCH[] = [$resource, $action, $controllerAction, $controller];
        if (is_null(self::$instance)) {
            new self();
        }
    }

    public static function delete(
        string $resource,
        string|null $action,
        string|null $controllerAction,
        string|null $controller = null
    ): void
    {
        self::$DELETE[] = [$resource, $action, $controllerAction, $controller];
        if (is_null(self::$instance)) {
            new self();
        }
    }

    public static function take(): ?RouteBuilder
    {
        return self::$instance;
    }

    public function run(Router $router): void
    {
        $routes = self::${$router->queryType};
        foreach ($routes as $route) {
            if (
                $route[0] == $router->resource
                &&
                $route[1] == $router->action
            ) {
                $router->controllerAction = $route[2];
                $router->controller = $route[3];
            }
        }
    }

    private function __construct()
    {
        self::$instance = $this;
    }
}
