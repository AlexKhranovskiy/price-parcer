<?php

namespace App\Controllers;

use App\models\File;
use App\Resources\FileResource;
use App\Services\FileManager;


class FilesController extends Controller
{
    private File $file;
    private FileResource $fileResource;
    private FileManager $fileManager;

    public function __construct()
    {

        $this->fileResource = new FileResource;
        $this->fileManager = new FileManager($_FILES);
        $this->file = new File($this->fileManager);
    }

    public function all(...$params): array|string
    {
        call_user_func_array($this->fileResource, [$this->file->getAll()]);
        return $this->fileResource->response();
    }

    public function save(...$params): array|string
    {
        $this->fileManager->save();
        call_user_func_array($this->fileResource, [
            $this->file->save($this->fileManager->getName())
        ]);
        return $this->fileResource->response();
    }

    public function delete(...$params)
    {
        /** @var $id */
        extract($params);
        $fileName = $this->file->findById($id)['directory'];
        $this->fileManager->delete($fileName);
        $this->file->deleteById($id);
        return true;
    }

}
