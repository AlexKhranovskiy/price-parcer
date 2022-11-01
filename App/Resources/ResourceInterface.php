<?php


namespace App\Resources;


use App\Interfaces\AdditionsForFileResource;

interface ResourceInterface extends AdditionsForFileResource
{
    public function set(array|null $data, int $code);

    public function response(): bool|string;
}