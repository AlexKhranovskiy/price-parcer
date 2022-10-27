<?php


namespace App\Resources;


class FileResource
{
    protected array $statuses = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    ];

    protected array|null $data;
    protected int $code;
    protected $template;
    protected array $additions;

    public int $id = 0;
    public string $name = '';
    public string $directory = '';
    public string $stored_at = '';

    public string $link = '';

    public array $result;

    public function set(array|null $data, int $code, ?callable $additions = null)
    {
        $this->data = $data;
        $this->code = $code;
        $this->template = new \ArrayObject($this);

        if (is_array($this->data)) {
            foreach ($this->data as &$item) {
                foreach ($this->template as $k => $tmp) {
                    if (isset($item[$k])) {
                        if (is_int($item[$k])) {
                            $item[$k] += $tmp;
                        }
                        if (is_string($item[$k])) {
                            $item[$k] .= $tmp;
                        }
                    } else {
                        $item[$k] = $tmp;
                        call_user_func_array($additions, ['link', &$item]);
                    }
                }
            }
        }
    }

    public function additions($name, &$item)
    {
        $directory = explode('/', $item['directory']);
        $item[$name] = $_SERVER['HTTP_HOST'] . $GLOBALS['storage'] . '/' .
            end($directory);
    }

//    public function set(string $callback)
//    {
//
//
//        if(is_array($this->data)) {
//            foreach ($this->data as &$item) {
//                foreach ($this->template as $k => $tmp) {
//                    if (isset($item[$k])) {
//                        if (is_int($item[$k])) {
//                            $item[$k] += $tmp;
//                        }
//                        if (is_string($item[$k])) {
//                            $item[$k] .= $tmp;
//                        }
//                    } else {
//                        $item[$k] = $tmp;
//                    }
//                }
//            }
//        }
//    }


//    public function __invoke(array|null $data, int $code)
//    {
//        $this->set($data, $code);
////        $this->link = array_map(function($value){
////            return 'http://' . $_SERVER['HTTP_HOST'] . $GLOBALS['storage'] . $value;
////        },$this->data);
//        foreach($this->data as $item){
//            $this->link[] = $item['name'];
//        }
//    }

    public function response()
    {
        //exit(var_dump($this->data));

        header("HTTP/1.1 " . $this->code . ' ' . $this->statuses[$this->code]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($this->data);
    }
}