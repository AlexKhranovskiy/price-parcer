<?php


namespace App\Resources;


class FileResource extends Resource
{
    public string $link = '';

    public function __invoke(array|bool|null $data)
    {
        $this->set($data);
        $this->link = 'http://' . $_SERVER['HTTP_HOST'] . $GLOBALS['storage'] . $this->name;
    }

    public function response()
    {
        if(is_array($this->data)) {
            $template = new \ArrayObject($this);
            foreach ($this->data as &$item) {
                foreach ($template as $k => $tmp) {
                    if (isset($item[$k])) {
                        if (is_int($item[$k])) {
                            $item[$k] += $tmp;
                        }
                        if (is_string($item[$k])) {
                            $item[$k] .= $tmp;
                        }
                    } else {
                        $item[$k] = $tmp;
                    }
                }
            }
        }
        header("HTTP/1.1 " . $this->code . ' ' . $this->statuses[$this->code]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($this->data);
    }
}