<?php

namespace App\Utils;

class UtilsService
{
    public static function hashSuffix($seed)
    {
        return '['.substr(hash('md5', $seed), 0, 5).']';
    }
}
