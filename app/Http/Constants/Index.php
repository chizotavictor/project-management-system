<?php

namespace App\Http\Constants;
use Carbon\Carbon;

class Index  
{
    public static function fdt($str) {
        if(isset($str)) {
            $fd = Carbon::createFromFormat('Y/d/m', $str);
            return $fd->format('d M, Y');
        } else {
            return "";
        }
    }
}
