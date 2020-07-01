<?php

namespace App\Helpers;

class StringHelper
{
    public static function removeSpecialChars(string $string)
    {
        return preg_replace('/\W/', '', $string);
    }

    public static function removeCep(string $cep)
    {
        return preg_replace('/-/', '', $cep);
    }

    public static function mask($val, $mask)
    {
        $masked = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $masked .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $masked .= $mask[$i];
                }
            }
        }
        return $masked;
    }
}
