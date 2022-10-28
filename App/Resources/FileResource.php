<?php

namespace App\Resources;

use App\Interfaces\AdditionsForFileResource;
use ArrayObject;

class FileResource extends Resource
{
    public int $id = 0;
    public string $name = '';
    public string $directory = '';
    public string $stored_at = '';

    public function set($data, $code)
    {
        parent::set($data, $code);
    }

    public function additions(string $fieldName, array &$value)
    {
        //Empty because this class has no additional fields to output
    }
}
