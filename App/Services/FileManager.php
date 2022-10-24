<?php


namespace App\Services;


use App\models\File;

class FileManager
{
    private array $Files;
    private $lastId;

    public function __construct(array $FILES, File $file)
    {
        $this->Files = $FILES;
        $this->lastId = current($file->getLastId());
    }

    public function save()
    {
        //$fileName = '2';
        $fileName = $this->codeName();
        //exit(var_dump($fileName));
        $error = $this->Files['file_image']['error'];
        if ($error == UPLOAD_ERR_OK) {
            move_uploaded_file(
                $this->Files['file_image']['tmp_name'], $fileName
            );
        }
    }

    public function codeName()
    {
        return $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' .
            $this->lastId++ . '-' . $this->Files['file_image']['name'];
    }
}