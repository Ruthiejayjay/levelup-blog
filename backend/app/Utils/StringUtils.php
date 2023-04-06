<?php

namespace App\Utils;

use Illuminate\Support\Str;

class StringUtils
{
    public static function slugify(string $value, int $numChunks = 4): string
    {
        // https://laravel.com/docs/9.x/helpers
        $slug = Str::of($value)->slug();
        $slug = $slug->explode('-')->take($numChunks)->implode('-');

        return $slug;
    }
}
