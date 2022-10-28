<?php


namespace App\Services;


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
                $this->Files['file_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $GLOBALS['storage'] . '/' . $fileName
            );
        } else {
            throw new \Exception('Error uploading file, ' . $error, 500);
        }
    }

    public function getName()
    {
        return $this->Files['file_image']['name'];
    }

    /**
     * @throws \Exception
     */
    public function delete(string|null $fileName)
    {
        if (!unlink($fileName)) {
            throw new \Exception('File not found', 500);
        }
    }
}