<?php

namespace App\Config;

use App\Router\Route;

Route::get('files', null, 'all');
//Route::get('home', null, 'home');
Route::post('files', null, 'save');
