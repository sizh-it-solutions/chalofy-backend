<?php

namespace App\Constants;

use Carbon\Carbon;

class DateFormat
{
    public const TIMEZONE = 'Asia/Kolkata';
    public const DISPLAY = 'd-m-Y h:i A';

    /**
     * Format a date in app standard timezone and display format.
     *
     * @param \Carbon\Carbon|string|null $date
     * @param string|null $format
     * @param string|null $timezone
     * @return string
     */
    public static function format($date, $format = null, $timezone = null): string
    {
        if (is_null($date)) {
            return '';
        }
        $format = $format ?? self::DISPLAY;
        $timezone = $timezone ?? self::TIMEZONE;
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->timezone($timezone)->format($format);
    }

    public static function toDateString($date, $timezone = null): string
{
    if (is_null($date)) {
        return '';
    }

    $timezone = $timezone ?? self::TIMEZONE;
    $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);

    return $carbon->timezone($timezone)->toDateString(); // returns 'Y-m-d'
}
}
