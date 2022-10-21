<?php


namespace App\Resources;


class FileResource extends Resource
{
    public ?string $link;

    public function __invoke(array $data)
    {
        $this->set($data);
        $this->link = 'http://' . $_SERVER['HTTP_HOST'];
    }
}