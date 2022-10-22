<?php

namespace App\Controllers;

use App\models\File;
use App\Resources\FileResource;


class FilesController extends Controller
{
    private File $file;
    private FileResource $fileResource;

    public function __construct()
    {
        $this->file  = new File;
        $this->fileResource = new FileResource;
    }

    public function all(...$params): array|string
    {
        call_user_func_array($this->fileResource, [$this->file->getAll()]);
        return $this->fileResource->response();
    }

    public function save(...$params): array|string
    {
        /** @var $name */
        extract($params);
        call_user_func_array($this->fileResource, [$this->file->save($name)]);
        return $this->fileResource->response();
    }


}
