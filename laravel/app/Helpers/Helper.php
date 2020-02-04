<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class Helper {

    /**
     * Return a Carbon instance.
     */
    function carbon(string $parseString = '', string $tz = null): Carbon
    {
        return new Carbon($parseString, $tz);
    }

    /**
     * Return a formatted Carbon date.
     */
    static function humanize_date(Carbon $date, string $format = 'd F Y, H:i'): string
    {
        return $date->format($format);
    }
}
