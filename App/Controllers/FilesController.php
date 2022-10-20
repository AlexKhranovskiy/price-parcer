<?php

namespace App\Controllers;

use App\models\File;


class FilesController extends Controller
{
    private File $file;

    public function __construct()
    {
        $this->file  = new File();
    }

    public function all(...$params): array|string
    {
        return 'all';
    }


}
