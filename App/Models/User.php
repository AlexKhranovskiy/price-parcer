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

    public function getByEmail(string $email, ?User &$user = null)
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
            $user = $this;
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

    public function attachToSubscription(Subscription $subscription) {
        if (is_null($subscription->id)) {
            throw new \Exception('Subscription model is empty.');
        } else {
            $sql = "insert into users_subscriptions (user_id, subscription_id) values (:user_id, :subscription_id)";
            $result = $this->db->pdo->prepare($sql);
            $result->bindParam(':user_id', $this->id);
            $result->bindParam(':subscription_id', $subscription->id);
            $result->execute();
            return $this;
        }
    }

    public function hasAttachedSubscription(Subscription $subscription)
    {
        $sql = "select * from users join users_subscriptions join subscriptions
                where users.id=users_subscriptions.user_id
                  and users_subscriptions.subscription_id=subscriptions.id
                  and subscriptions.id=:id_subscription
                  and users.id=:id_user";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'id_subscription' => $subscription->id,
            'id_user' => $this->id
        ]);
        if($result->fetch(Database::FETCH_ASSOC)){
            return true;
        } else {
            return false;
        }
    }

//    public function getAllWithSubscriptions(): ?array
//    {
//        $rows = [];
//        $sql = "select * from users join subscriptions where users.id=subscriptions.user_id";
//        $result = $this->db->pdo->prepare($sql);
//        $result->execute();
//        while(true){
//            $row = $result->fetch(Database::FETCH_ASSOC);
//            if($row) {
//                $rows[] = $row;
//            } else {
//                break;
//            }
//        }
//        if(sizeof($rows) > 0) {
//            return $rows;
//        } else {
//            return null;
//        }
//    }
}