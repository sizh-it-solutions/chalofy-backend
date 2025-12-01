<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{AppUser,Booking};

class VendorWallet extends Model
{
    protected $fillable = [
        'vendor_id', 'amount', 'booking_id', 'payout_id', 'type','description'
    ];
    
    protected $casts = [
        'vendor_id' => 'string',
        'booking_id' => 'string',
        'payout_id' => 'string',
        'amount' => 'string'

    
    
    ];
    // Add any additional relationships or methods you may need

    // Disable timestamps if not needed
    public $timestamps = true;

    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'vendor_id');
    }
    public function booking()
{
    return $this->belongsTo(Booking::class, 'booking_id');
}
}
