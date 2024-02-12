<?php

namespace App\Resources;

interface ResourceInterface
{
    public function response(array $data, int $code): bool|string;
}