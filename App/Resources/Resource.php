<?php

namespace App\Resources;

use ArrayObject;

class Resource implements ResourceInterface
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
    protected ArrayObject $template;

    public function set(array|null $data, int $code)
    {
        $this->data = $data;
        $this->code = $code;
        $this->template = new ArrayObject($this);

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
                        $item[$k] = $tmp; // if added new field (to template) to output with JSON
                        call_user_func_array([$this, 'additions'], ['link', &$item]);
                    }
                }
            }
        }
    }

    public function response(): bool|string
    {
        if (empty($this->data)) {
            $this->code = 204;
        }
        header("HTTP/1.1 " . $this->code . ' ' . $this->statuses[$this->code]);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($this->data);
    }

    public function additions(string $fieldName, array &$value)
    {
        //Empty because this class has no additional fields to output
    }
}
