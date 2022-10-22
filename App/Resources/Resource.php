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

    public function response()
    {
        if(is_array($this->data)) {
            $additions = new \ArrayObject($this);
            foreach ($this->data as &$item) {
                foreach ($additions as $key => $addition) {
                    $item[$key] = $addition;
                }
            }
        }
        header("HTTP/1.1 " . $this->code . ' ' . $this->statuses[$this->code]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($this->data);
    }

    //abstract public function __invoke(array $data);
}