<?php

namespace App\Models;

use App\Database\Database;

class Subscription
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
        $this->url = $url;
        return $this;
    }

    public function setPriceAndCurrencyCode(string $price, string $currencyCode)
    {
        if (is_null($this->id)) {
            throw new \Exception('Subscription model is empty.', 500);
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

    public function getByUrl($url, ?Subscription &$subscription = null)
    {
        $sql = "select * from subscriptions where url=:url";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'url' => $url
        ]);
        $result = $result->fetch(Database::FETCH_ASSOC);
        if (isset($result['id'])) {
            $this->id = $result['id'];
            $this->url = $result['url'];
            return $this;
        } else {
            $subscription = $this;
            return null;
        }

    }

    public function findOrAddNew($url)
    {
        $subscription = $this->getByUrl($url);
        if (!is_null($subscription)) {
            return $subscription;
        } else {
            return $this->addNew($url);
        }
    }

    public function hasAttachedUser(User $user)
    {
        $sql = "select * from subscriptions join users_subscriptions join users
                where users_subscriptions.subscription_id=subscriptions.id
                  and users.id=users_subscriptions.user_id
                  and users.id=:id";
        $result = $this->db->pdo->prepare($sql);
        $result->execute([
            'id' => $user->id
        ]);
        if ($result->fetch(Database::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
    }

    public function attachToUser(User $user): static
    {
        $sql = "insert into users_subscriptions (user_id, subscription_id) values (:user_id, :subscription_id)";
        $result = $this->db->pdo->prepare($sql);
        $result->bindParam(':user_id', $user->id);
        $result->bindParam(':subscription_id', $this->id);
        $result->execute();
        return $this;

    }

    public function getAllWithUsers()
    {
        $rows = [];
        $sql = "select subscriptions.id,subscriptions.url, subscriptions.price, users.email from subscriptions
                join users_subscriptions on subscriptions.id = users_subscriptions.subscription_id
                join users on users_subscriptions.user_id = users.id";
        $result = $this->db->pdo->prepare($sql);
        $result->execute();
        $emails = [];
        while (true) {
            $row = $result->fetch(Database::FETCH_ASSOC);
            if ($row) {
                $emails[$row['id']][] = $row['email'];
                $rows[$row['id']] = [
                    'url' => $row['url'],
                    'price' => $row['price']
                ];
            } else {
                break;
            }
        }
        if (sizeof($rows) > 0) {
            foreach ($emails as $key => $email) {
                $rows[$key]['email'][] = $email;
            }
            return $rows;
        } else {
            return null;
        }
    }
}