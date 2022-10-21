<?php


namespace App\Resources;


abstract class FileResource
{
    use Responsible;

    protected $id;
    protected $name;
    protected $directory;
    protected $stored_at;
    protected $link;
}