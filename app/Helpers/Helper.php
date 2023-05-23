<?php

namespace App\Helpers;

class Helper
{
    public static function myCustomFunction($value)
    {
        if(empty($value)){
            return "This is a random description...";
        }
        return $value;
    }
}
