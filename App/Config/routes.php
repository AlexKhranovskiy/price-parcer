<?php

namespace App\Config;

use App\Router\RouteBuilder;

RouteBuilder::get('files', null, 'all');
RouteBuilder::post('files', null, 'save');
RouteBuilder::delete('files', null, 'delete');
