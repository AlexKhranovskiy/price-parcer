<?php


namespace App\Interfaces;


use App\models\File;

interface Repository
{
    public function save(string $fileName);
    public function getAll();
    public function findById(int $id);
    public function findByName(string $name);
}