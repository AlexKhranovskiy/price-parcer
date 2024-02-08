<?php

namespace App\Models;

use App\Database\Database;

class Subscription extends Model
{
    protected Database $db;
    protected User $user;

    public function __construct(Database $db, User $user)
    {
        $this->db = $db;
        $this->user = $user;

    }

    public function addNew(string $url)
    {
        $sql = "insert into subscriptions (url) values (
                    :url     
                   )";
        $result = $this->db->pdo->prepare($sql);
        $result->bindParam(':url', $url);
        $result->execute();
        $this->id = $this->db->pdo->lastInsertId();
        return $this;
    }

    public function attachToUser(User $user)
    {
        if (is_null($this->id)) {
            throw new \Exception('Subscription model is empty.');
        } else {
            $sql = "update subscriptions set user_id=:user_id where id=:id";
            $result = $this->db->pdo->prepare($sql);
            $result->bindParam(':user_id', $user->id);
            $result->bindParam(':id', $this->id);
            $result->execute();
            return $this;
        }
    }

    public function setPriceAndCurrencyCode(string $price, string $currencyCode)
    {
        if (is_null($this->id)) {
            throw new \Exception('Subscription model is empty.');
        } else {
            $sql = "update subscriptions set price=:price, currencyCode=:currencyCode where id=:id";
            $result = $this->db->pdo->prepare($sql);
            $result->bindParam(':price', $price);
            $result->bindParam(':currencyCode', $currencyCode);
            $result->bindParam(':id', $this->id);
            $result->execute();
            $this->price = $price;
            $this->currencyCode = $currencyCode;
            return $this;
        }
    }
}