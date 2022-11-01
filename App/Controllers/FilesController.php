<?php

namespace App\Controllers;

use App\Models\File;
use App\Resources\FileResourceWithLink;
use App\Resources\ResourceInterface;

class FilesController extends Controller
{
    private File $file;
    private FileResourceWithLink $fileResourceWithLink;
    private ResourceInterface $resource;

    public function __construct(File $file, ResourceInterface $resource)
    {
        $this->resource = $resource;
        $this->file = $file;
    }

    public function all(...$params): array|string
    {
        $this->resource->set($this->file->getAll(), 200);
        return $this->resource->response();
    }

    /**
     * @throws \Exception
     */
    public function save(...$params): array|string
    {
        $this->file->fileManager->save();
        $this->resource->set(
            $this->file->save($this->file->fileManager->getName()),
            201
        );
        return $this->resource->response();
    }

    /**
     * @throws \Exception
     */
    public function delete(...$params)
    {
        try {
            /** @var $id */
            extract($params);
            $fileName = $this->file->findById($id)['directory'];
            $this->file->fileManager->delete($fileName);
            $this->file->deleteById($id);
            $this->resource->set(
                $this->file->deleteById($id),
                201
            );
            return $this->resource->response();
        } catch (\Exception $eFileNotFound) {
            try {
                $this->file->deleteById($id);
            } catch (\Exception $eCantDeleteFromDB) {
                throw new \Exception($eFileNotFound->getMessage() .
                    ' and ' . $eCantDeleteFromDB->getMessage(), 500);
            }
            throw new \Exception($eFileNotFound->getMessage() .
                ', record was successfully deleted.', $eFileNotFound->getCode());
        }
    }
}
