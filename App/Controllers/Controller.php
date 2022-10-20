<?php

namespace App\Controllers;

use App\Models\Model;
use App\Views\Responser;

abstract class Controller
{
    /**
     * @throws \Exception
     */
    public static function run(
        string $resource,
        int|null $id,
        string|null $action,
        array $queryParams,
        string|null $controller,
    ): array|string|null {
        if (!is_null($controller)) {
            $controllerName = $controller;
        } else {
            $controllerName = $resource . 'Controller';
        }
        $controllerClass = __NAMESPACE__ . '\\' . ucfirst($controllerName);
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            $params = (is_null($id) && !empty($queryParams)) ? $queryParams : [$id, $queryParams];
            return call_user_func_array([$controller, $action], $params);
        } else {
            throw new \Exception('Not found', 404);
        }
    }
}
