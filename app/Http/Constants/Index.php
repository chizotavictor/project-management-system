<?php

namespace App\Http\Constants;
use Carbon\Carbon;

class Index
{
    const IN_REVIEW = 'In-Review';
    const IN_PROGRESS = 'In-Progress';
    const CLOSED = 'Closed';
    const OPEN = 'Open';
    const IN_ACTIVE = 'In-Active';
    const ACTIVE = 'Active';
    const PENDING = 'Pending';
    const COMPLETED = 'Completed';
    const SUBMITTED = "Submitted";

    public static function fdt($str) {
        if(isset($str)) {
            $fd = Carbon::createFromFormat('Y/d/m', $str);
            return $fd->format('d M, Y');
        } else {
            return "";
        }
    }
}
