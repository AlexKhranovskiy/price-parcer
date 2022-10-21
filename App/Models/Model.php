<?php

namespace App\Models;

use App\Database\Database;

class Model
{
    private static Database $_db;
    private static string $_storage;
    protected Database $db;
    protected string $storage;

    public static function set(Database $db, string $storage)
    {
        self::$_db = $db;
        self::$_storage = $storage;
    }

    protected function __construct()
    {
        $this->storage = self::$_storage;
        $this->db = self::$_db;
    }
}
