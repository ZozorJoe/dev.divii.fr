<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Arr;

class Code
{
    public function generate(int $length = 6): string
    {
        $string = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        do{
            $code = implode('', Arr::random(str_split($string), $length));
            $exists = User::where('code', '=', $code)->exists();
        }while ($exists);

        return $code;
    }

}
