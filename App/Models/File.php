<?php

namespace App\models;

use App\Database\Database;
use App\Interfaces\Repository;
use App\Services\FileManager;

class File implements Repository
{
    protected Database $db;
    protected string $storage;
    public FileManager $fileManager;

    public function __construct(Database $db, string $storage, FileManager $fileManager)
    {
        $this->storage = $storage;
        $this->db = $db;
        $this->fileManager = $fileManager;
    }

    public function save(string $fileName)
    {
        $sql = "insert into files (name, directory, stored_at) values (
                    :fileName,
                    :directory,
                    NOW()       
                   )";
        $result = $this->db->pdo->prepare($sql);
        $result->bindParam(':fileName', $fileName);
        $storage = $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' .
            $this->fileManager->encodedName;
        $result->bindParam(':directory', $storage);
        $result->execute();
        return null;
    }

    public function getAll(): array
    {
        $sql = "select * from files";
        $result = $this->db->pdo->prepare($sql);
        $result->execute();
        return $result->fetchAll(Database::FETCH_ASSOC);
    }

    /**
     * @throws \Exception
     */
    public function findById(int $id)
    {
        $sql = "select * from files where id=:id";
        $result = $this->db->pdo->prepare($sql);
        try {
            $result->execute([
                'id' => $id
            ]);
            return $result->fetch(Database::FETCH_ASSOC);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), 500);
        }
    }

    public function findByName(string $name): array
    {
        $sql = "select * from files where name=:name";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'name' => $name
        ]);
        return $result->fetchAll(Database::FETCH_ASSOC);
    }

    public function deleteById(int $id)
    {
        $sql = "delete from files where id=:id";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        return null;
    }
}
