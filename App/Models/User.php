<?php

namespace App\Models;

use App\Database\Database;
use App\Services\FileManager;

class User extends Model
{
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getById(int $userId): ?static
    {
        $sql = "select * from users where id=:id";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'id' => $userId
        ]);
        $result = $result->fetch(Database::FETCH_ASSOC);
        if(isset($result['id'])) {
            $this->id = $result['id'];
            $this->email = $result['email'];
            return $this;
        } else {
            return null;
        }
    }

    public function getByEmail(string $email)
    {
        $sql = "select * from users where email=:email";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'email' => $email
        ]);
        $result = $result->fetch(Database::FETCH_ASSOC);
        if(isset($result['id'])) {
            $this->id = $result['id'];
            $this->email = $result['email'];
            return $this;
        } else {
            return null;
        }
    }

    public function addNew(string $email): static
    {
        $sql = "insert into users (email) values (:email)";
        $result = $this->db->pdo->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();
        $this->id = $this->db->pdo->lastInsertId();
        $this->email = $email;
        return $this;
    }

    public function findOrAddNew(string $email)
    {
        $user = $this->getByEmail($email);
        if(!is_null($user)){
            return $user;
        } else {
            return $this->addNew($email);
        }
    }
}