<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function parseDateTime(string $date)
    {
        return Carbon::parse($date)->toDateTimeString();
    }

    public static function formatDate($date, $format = 'd/m/Y')
    {
        return Carbon::parse($date)->format($format);
    }
}
