<?php

namespace App\Interfaces;

interface Repository
{
    public function save(string $fileName);
    public function getAll();
    public function findById(int $id);
    public function findByName(string $name);
}
