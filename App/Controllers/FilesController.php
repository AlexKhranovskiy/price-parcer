<?php

namespace App\Controllers;

use App\models\File;
use App\Resources\FileResourceWithLink;


class FilesController extends Controller
{
    private File $file;
    private FileResourceWithLink $fileResourceWithLink;

    public function __construct(File $file)
    {
        $this->fileResourceWithLink = new FileResourceWithLink;
        $this->file = $file;
    }

    public function all(...$params): array|string
    {
        $this->fileResourceWithLink->set($this->file->getAll(), 200);
        return $this->fileResourceWithLink->response();
    }

    public function save(...$params): array|string
    {
        $this->file->fileManager->save();
        $this->fileResourceWithLink->set(
            $this->file->save($this->file->fileManager->getName()), 201
        );
        return $this->fileResourceWithLink->response();
    }

    public function delete(...$params)
    {
//        try {
            /** @var $id */
            extract($params);
            $fileName = $this->file->findById($id)['directory'];
            $this->file->fileManager->delete($fileName);
            $this->file->deleteById($id);
            $this->fileResourceWithLink->set(
                $this->file->deleteById($id), 201
            );
            return $this->fileResourceWithLink->response();
//        } catch (\Exception $exception) {
//            throw new \Exception($exception->getMessage(), $exception->getCode());
//        }
    }

}
