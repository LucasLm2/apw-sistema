<?php

namespace App\Helpers;

class ManipulacaoString
{
    public static function limpaString(string $dado): string
    {
        $caracteres = ['-', '.', ' ', '(', ')', '/'];

        return str_replace($caracteres, '', $dado);
    }
}