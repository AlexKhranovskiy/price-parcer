<?php


namespace App\Resources;


abstract class Resource
{
    protected array $statuses = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    ];
    protected int $code;

    public int $id = 0;
    public string $name = '';
    public string $directory = '';
    public string $stored_at = '';

    protected array|null $data;

    public function set(array|null$data, int $code)
    {
        $this->data = $data;
        $this->code = $code;
    }

    abstract public function response();
}