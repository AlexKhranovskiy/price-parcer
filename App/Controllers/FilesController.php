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
        $this->file = new File;
        $this->fileResource = new FileResource;
    }

    public function all(...$params): array|string
    {
        call_user_func_array($this->fileResource, [$this->file->getAll()]);
        return $this->fileResource->response();
    }

    public function save(...$params): array|string
    {
        $fileName = $_FILES['file_image']['name'];
        $error = $_FILES['file_image']['error'];
        if ($error == UPLOAD_ERR_OK) {
            move_uploaded_file(
                $_FILES['file_image']['tmp_name'],
                $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' . $fileName
            );
        }
        call_user_func_array($this->fileResource, [$this->file->save($fileName)]);
        return $this->fileResource->response();
    }


}
