<?php

namespace App\Config;

$connection = [
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'userName' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'database' => getenv('DB_DATABASE'),
    'port' => getenv('DB_PORT'),
    'charset' => getenv('DB_CHARSET'),
];
