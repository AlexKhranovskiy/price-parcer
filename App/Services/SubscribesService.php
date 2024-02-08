<?php

namespace App\Services;

use App\Database\Database;
use App\Models\Subscription;
use App\Models\User;

class SubscribesService
{
    protected Database $database;
    protected AdService $adService;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->adService = new AdService();
    }
    public function subscribe(string $url, string $email)
    {
        $source = $this->adService->getSource($url);
        $priceAndCurrency = $source->getPriceAndCurrencyCode();

        $user = new User($this->database);
        $user = $user->findOrAddNew($email);

        $subscription = new Subscription($this->database, $user);
        $subscription = $subscription->addNew($url);
        $subscription = $subscription->attachToUser($user);
        $subscription->setPriceAndCurrencyCode($priceAndCurrency['price'], $priceAndCurrency['currencyCode']);
    }
}