<?php


namespace App\Resources;


use App\Interfaces\AdditionsForFileResource;

class FileResourceWithLink extends FileResource implements AdditionsForFileResource
{
    public string $link = '';

    public function set($data, $code)
    {
        parent::set($data, $code);
    }

    public function additions(string $fieldName, array &$value)
    {
        $directory = explode('/', $value['directory']);
        $value[$fieldName] = $_SERVER['HTTP_HOST'] . $GLOBALS['storage'] . '/' .
            end($directory);
    }
}