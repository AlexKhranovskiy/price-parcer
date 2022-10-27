<?php


namespace App\Interfaces;


interface AdditionsForFileResource
{
    public function additions(string $fieldName, array &$value);
}