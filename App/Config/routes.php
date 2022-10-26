<?php

namespace App\Config;

use App\Router\Route;

Route::get('files', null, 'all');
Route::post('files', null, 'save');
Route::delete('files', null, 'delete');
