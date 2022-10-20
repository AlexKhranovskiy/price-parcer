<?php

namespace App\Models;

use App\Database\Database;

abstract class Model
{
    public static Database $db;
    public static function run(Database $database)
    {
        self::$db = $database;
    }
}
