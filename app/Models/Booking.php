<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\Traits\MiscellaneousTrait;
use App\Models\Modern\Item;
use App\Models\BookingExtension;
use App\Models\BookingFinance;

class Booking extends Model
{
    use HasFactory, SoftDeletes, MiscellaneousTrait;

    public $table = 'bookings';

    public const BOOK_FOR_SELECT = [
        'self' => 'self',
        'Other' => 'Other',
    ];

    public const CANCELLED_BY_SELECT = [
        'Host' => 'Host',
        'Guest' => 'Guest',
    ];

    protected $casts = [
        'host_id' => 'string',
        'total_day' => 'string',
        'total_guest' => 'string',
        'rating' => 'string',
        'module' => 'string',
    ];

    protected $dates = [
        'check_in',
        'check_out',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'token',
        'itemid',
        'host_id',
        'userid',
        'check_in',
        'check_out',
        'start_time',
        'end_time',
        'status',
        'total_day',
        'per_day',
        'module',
        'item_data', 
        'cancellation_reasion',
         'cancelled_by',
         'currency_code',
         'total',
         'amount_to_pay',
         'payment_method',
          'transaction',

    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function host()
    {
        return $this->belongsTo(AppUser::class, 'host_id');
    }

    public function user()
    {
        return $this->belongsTo(AppUser::class, 'userid');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid');
    }

    public function extension()
    {
        return $this->hasOne(BookingExtension::class, 'booking_id', 'id');
    }

    public function bookingFinance()
    {
        return $this->hasOne(BookingFinance::class, 'booking_id', 'id');
    }

    public function getCheckInAttribute($value)
    {
        // return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
         return $value ? Carbon::parse($value)->format('d-m-Y h:i A') : null;
    }

    public function setCheckInAttribute($value)
    {
        // $this->attributes['check_in'] = $value
        //     ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d')
        //     : null;
          $this->attributes['check_in'] = $value
        ? Carbon::parse($value)->format('Y-m-d H:i:s')
        : null;
    }

    public function getCheckOutAttribute($value)
    {
         return $value ? Carbon::parse($value)->format('d-m-Y h:i A') : null;
    }

    public function setCheckOutAttribute($value)
    {
         $this->attributes['check_out'] = $value
        ? Carbon::parse($value)->format('Y-m-d H:i:s')
        : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->token = $booking->generateUniqueBookingToken();
        });
    }

    public function generateUniqueBookingToken()
    {
        $tokenLength = 9;
        $uniqueToken = $this->generateRandomChars($tokenLength);

        while (static::where('token', $uniqueToken)->exists()) {
            $uniqueToken = $this->generateRandomChars($tokenLength);
        }

        return $uniqueToken;
    }


}
