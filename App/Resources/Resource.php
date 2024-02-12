<?php

namespace App\Resources;

abstract class Resource implements ResourceInterface
{
    protected array $statuses = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    ];


    public function response(array $data, int $code): bool|string
    {
        header("HTTP/1.1 " . $code . ' ' . $this->statuses[$code]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }
}