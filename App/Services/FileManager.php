<?php


namespace App\Services;


use App\models\File;

class FileManager
{
    private array $Files;
    private File $file;

    public function __construct(array $FILES, File $file)
    {
        $this->Files = $FILES;
        $this->file = $file;
    }

    public function save()
    {
        $fileName = $this->encodeName();

        $error = $this->Files['file_image']['error'];
        if ($error == UPLOAD_ERR_OK) {
            move_uploaded_file(
                $this->Files['file_image']['tmp_name'], $fileName
            );
        }
    }

    public function encodeName(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' .
            $this->file->getLastId() + 1 . '-' . $this->Files['file_image']['name'];
    }

    public function getName()
    {
        return $this->Files['file_image']['name'];
    }

    public function deleteById(int $id)
    {
        $fileName = $this->file->findById($id)['directory'];
        unlink($fileName);
    }
}