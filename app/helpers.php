<?php

use App\Models\Modern\Currency;
function shortenPropertyName($propertyName, $maxLength = 50, $suffix = '...')
{
    if (strlen($propertyName) <= $maxLength) {
        return $propertyName;
    }
    return substr($propertyName, 0, $maxLength - strlen($suffix)) . $suffix;
}

if (!function_exists('maskEmail')) {
    function maskEmail($email)
    {
        $emailParts = explode('@', $email);
        $username = $emailParts[0];
        $domain = $emailParts[1];
        if (strlen($username) > 6) {
            $maskedUsername = substr($username, 0, 5) . str_repeat('*', strlen($username) - 4) . substr($username, -2);
        } else {
            $maskedUsername = $username;
        }
        if (strlen($maskedUsername) > 10) {
            $maskedUsername = substr($maskedUsername, 0, 8) . '...';
        }
        $maskedDomain = strlen($domain) > 15 ? '...' . substr($domain, -13) : $domain;
        return $maskedUsername . '@' . $maskedDomain;
    }
}

if (!function_exists('maskPhone')) {
    function maskPhone($phone)
    {
        return $phone ? substr($phone, 0, -6) . str_repeat('*', 6) : '';
    }
}

if (!function_exists('checkAvailability')) {
    /**
     * Check if an item is available for booking in the given date + time range,
     * enforcing a configurable buffer before and after the desired slot.
     *
     * @param int|string $itemId
     * @param string $startDatetime // Y-m-d H:i:s
     * @param string $endDatetime   // Y-m-d H:i:s
     * @param int|null $ignoreBookingId (optional, for edit scenarios)
     * @param int $bufferMinutes (default 30 minutes)
     * @return bool
     */
    function checkAvailability($itemId, $startDatetime, $endDatetime, $ignoreBookingId = null, $bufferMinutes = 30)
    {
        $adjustedStart = \Carbon\Carbon::parse($startDatetime)
            ->subMinutes($bufferMinutes)
            ->format('Y-m-d H:i:s');

        $adjustedEnd = \Carbon\Carbon::parse($endDatetime)
            ->addMinutes($bufferMinutes)
            ->format('Y-m-d H:i:s');

        $query = \App\Models\Booking::where('itemid', $itemId)
            ->whereIn('status', ['Pending', 'Confirmed', 'Completed'])
            ->where(function ($q) use ($adjustedStart, $adjustedEnd) {
                $q->where('check_in', '<', $adjustedEnd)
                    ->where('check_out', '>', $adjustedStart);
            });

        if ($ignoreBookingId) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        return !$query->exists(); // true = available, false = conflict
    }


}

function formatCurrency($number, $decimals = 2, $decimal_separator = '.', $thousands_separator = ',', $forDb = false)
{
    $number = $number ?? 0;
    if ($number == 0) {
        return '0.00';
    }

    if ($forDb) {
        // Return raw numeric value for DB usage, ensuring it's still rounded consistently
        return number_format((float) $number, $decimals);
    }

    $locale = Config::get('general.default_locale_currency') ?? 'en-US';

    if (class_exists('NumberFormatter')) {
        $formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);
       return $formatter->format((float)$number);
    }

    return number_format($number, $decimals, $decimal_separator, $thousands_separator);
}
function formatCurrencyForDb($number, $forDb = false)
{
    return formatCurrency($number, 2, '.', ',', $forDb);
}