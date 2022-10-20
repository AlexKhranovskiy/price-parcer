<?php

namespace App\models;

use App\Database\Database;
use App\Interfaces\Repository;

class File extends Model implements Repository
{
    private Database $database;

    public function __construct()
    {
        $this->database = self::$db;
    }

    public function save(string $fileName): bool
    {
        $sql = "insert into files (
                   'name',
                   'directory',
                   'stored_at'
                   )
                    values (
                    :fileName,
                    :directory,
                    NOW()       
                   )";
        $result = $this->database->pdo->prepare($sql);
        $result->bindParam(':fileName', $fileName);
        $result->bindParam(':directory', $fileName);
        $result->execute();
        //return true;
    }

    public function getAll(): array
    {
        $sql = "select * from files";
        $result = $this->database->pdo->prepare($sql);
        $result->execute();
        return $result->fetchAll(Database::FETCH_ASSOC);
    }

    public function findById(int $id)
    {
        $sql = "select * from files where id=:id";
        $result = $this->database->pdo->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        return $result->fetch(Database::FETCH_ASSOC);
    }

    public function findByName(string $name): array
    {
        $sql = "select * from files where name=:name";
        $result = $this->database->pdo->prepare($sql);
        $result->execute([
            'name' => $name
        ]);
        return $result->fetchAll(Database::FETCH_ASSOC);
    }
}
