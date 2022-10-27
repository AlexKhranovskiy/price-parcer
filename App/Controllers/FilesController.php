<?php

namespace App\Controllers;

use App\models\File;
use App\Resources\FileResource;
use App\Services\FileManager;


class FilesController extends Controller
{
    private File $file;
    private FileResource $fileResource;

    public function __construct(File $file)
    {
        $this->fileResource = new FileResource;
        $this->file = $file;
    }

    public function all(...$params): array|string
    {
        $additions = function($name, &$item)
        {
            $directory = explode('/', $item['directory']);
            $item[$name] = $_SERVER['HTTP_HOST'] . $GLOBALS['storage'] . '/' .
                end($directory);
        };

        $this->fileResource->set($this->file->getAll(), 200, $additions);
        return $this->fileResource->response();
    }

    public function save(...$params): array|string
    {
/*        $func = function($name, &$item)
        {
            $directory = explode('/', $item['directory']);
            $item[$name] = $_SERVER['HTTP_HOST'] . $GLOBALS['storage'] . '/' .
                end($directory);
        };*/

        $this->file->fileManager->save();
        $this->fileResource->set(
            $this->file->save($this->file->fileManager->getName()), 201
        );
        return $this->fileResource->response();
    }

    public function delete(...$params)
    {
        /** @var $id */
        extract($params);
        $fileName = $this->file->findById($id)['directory'];
        $this->file->fileManager->delete($fileName);
        $this->file->deleteById($id);
        $this->fileResource->set(
            $this->file->deleteById($id), 201
        );
        return $this->fileResource->response();
    }

}
