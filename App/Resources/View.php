<?php

namespace App\Views;

abstract class View
{
    protected array $replacements = [
        '{{{title}}}' => '',
        '{{{body}}}' => ''
    ];
    protected const LAYOUT = <<<HTML
	<!DOCTYPE html>
	<html lang="ru">
	<head>
		<title>{{{title}}}</title>
		<meta charset="utf-8">
	</head>
	<body>
		{{{body}}}		
	</body>
	</html>
	HTML;

    public function render(): array|string
    {
        return str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            self::LAYOUT
        );
    }
}
