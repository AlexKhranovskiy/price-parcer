<?php

namespace App\Controllers;

use App\models\File;


class FilesController extends Controller
{
    private File $file;

    public function __construct()
    {
        $this->file  = new File();
    }

    public function all(...$params): array|string
    {
        return print_r($this->file->getAll());
    }

    public function save(...$params): array|string
    {
        /** @var $name */
        extract($params);
        //$this->file->save($name);
        return $name;
    }


}
