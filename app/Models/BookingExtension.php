<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingExtension extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'is_item_deliver',
        'is_item_received',
        'is_item_returned',
        'pick_otp',
        'drop_otp'
    ];

    // Relationship to the Booking model
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
