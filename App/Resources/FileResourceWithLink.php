<?php


namespace App\Resources;


class FileResourceWithLink extends FileResource
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