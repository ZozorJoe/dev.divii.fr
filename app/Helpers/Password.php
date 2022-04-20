<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class Password
{
    public function generate(int $length = 8): string
    {
        // Do not add o,O,0,i,I,l,L
        $string = "abcdefghjkmnpqrstuwxyzABCDEFGHJKMNPQRSTUWXYZ123456789";
        return implode('', Arr::random(str_split($string), $length));
    }

}
