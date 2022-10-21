<?php


namespace App\Resources;


abstract class Resource
{
    private array $statuses = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    ];
    protected int $code;

    public int|null $id = null;
    public string|null $name = null;
    public string|null $directory = null;
    public string|null $stored_at = null;
    //public $link;


    public function set(array|bool $data)
    {
        if(is_array($data)) {
            /** @var $id */
            /** @var $name */
            /** @var $directory */
            /** @var $stored_at */
            extract($data[0]);
            $this->id = $id;
            $this->name = $name;
            $this->directory = $directory;
            $this->stored_at = $stored_at;
            $this->code = 200;
        }
        if(is_bool($data)) {
            $this->code = 201;
        }
        if(is_null($data)){
            $this->code = 204;
        }
    }

    public function response()
    {
        $data = new \ArrayObject($this);
        header("HTTP/1.1 " . $this->code . ' ' . $this->statuses[$this->code]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }
}