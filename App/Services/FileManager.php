<?php


namespace App\Services;


use App\models\File;
use mysql_xdevapi\Exception;

class FileManager
{
    private array $Files;
    public string $encodedName;

    public function __construct(array $FILES)
    {
        $this->Files = $FILES;
    }

    public function save()
    {
        $this->encodedName = microtime(true) . $this->Files['file_image']['name'];
        $fileName = $this->encodedName;

        $error = $this->Files['file_image']['error'];
        if ($error == UPLOAD_ERR_OK) {
            move_uploaded_file(
                $this->Files['file_image']['tmp_name'],  $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' .$fileName
            );
        }
    }

    public function getName()
    {
        return $this->Files['file_image']['name'];
    }

    public function delete(string $fileName)
    {
        try {
            unlink($fileName);
        } catch (\Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }
}