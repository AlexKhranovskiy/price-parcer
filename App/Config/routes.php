<?php

namespace App\Config;

use App\Router\RouteBuilder;

RouteBuilder::get('files', null, 'all');
RouteBuilder::post('subscribes', null, 'subscribe');
RouteBuilder::delete('files', null, 'delete');
