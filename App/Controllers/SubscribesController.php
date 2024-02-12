<?php

namespace App\Controllers;

use App\Database\Database;
use App\Resources\Resource;
use App\Resources\SubscribesResource;
use App\Services\SubscribesService;

class SubscribesController extends Controller
{
    protected Database $database;
    protected Resource $resource;
    protected SubscribesService $subscribesService;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->resource = new SubscribesResource();
        $this->subscribesService = new SubscribesService($database);
    }

    public function subscribe(...$params)
    {
        $this->subscribesService->subscribe($params['url'], $params['email']);
        return $this->resource->response([
            'success' => true,
            'message' => 'Subscription completed successfully'
        ], 200);
    }
}