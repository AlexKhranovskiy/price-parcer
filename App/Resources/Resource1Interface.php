<?php

namespace App\Resources;

interface Resource1Interface
{
    public function response(array $data, int $code): bool|string;
}