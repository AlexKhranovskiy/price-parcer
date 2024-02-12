<?php

namespace App\Controllers;

use App\Database\Database;

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
        Database $db
    ): array|string|null {
        if (!is_null($controller)) {
            $controllerName = $controller;
        } else {
            $controllerName = $resource . 'Controller';
        }
        $controllerClass = __NAMESPACE__ . '\\' . ucfirst($controllerName);
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($db);
            $params = (is_null($id) && !empty($queryParams)) ? $queryParams : [
                'id' => $id,
                'queryParams' => $queryParams
            ];
            return call_user_func_array([$controller, $action], $params);
        } else {
            throw new \Exception('Not found', 404);
        }
    }
}
