<?php


namespace App\Services;


use App\models\File;

class FileManager
{
    private array $Files;
    private mixed $lastId;

    public function __construct(array $FILES, File $file)
    {
        $this->Files = $FILES;
        $this->lastId = $file->getLastId();
    }

    public function save()
    {
        $fileName = $this->getCodeName();

        $error = $this->Files['file_image']['error'];
        if ($error == UPLOAD_ERR_OK) {
            move_uploaded_file(
                $this->Files['file_image']['tmp_name'], $fileName
            );
        }
    }

    public function getCodeName(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' .
            $this->lastId++ . '-' . $this->Files['file_image']['name'];
    }

    public function getFileName()
    {
        return $this->Files['file_image']['name'];
    }
}