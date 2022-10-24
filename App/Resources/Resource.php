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

    protected array|bool|null $data;

    public function set(array|bool $data, ?int $code = null)
    {
        $this->data = $data;
        if(is_array($data)) {
            $this->code = 200;
        }
        if(is_bool($data)) {
            $this->code = 201;
        }
        if(is_null($data)){
            $this->code = 204;
        }
    }

    abstract public function response();
}