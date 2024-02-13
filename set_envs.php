<?php

$file = fopen('.env', 'r');
while ($string = fgets($file)) {
    putenv($string);
}
fclose($file);

var_dump(getenv('DB_HOST') ?? 'emp');