<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingFinance extends Model
{
    use HasFactory;

    protected $table = 'booking_finance';

    protected $fillable = [
        'booking_id',
        'total_day',
        'per_day',
        'base_price',
        'doorstep_price',
        'security_money',
        'iva_tax',
        'coupon_code',
        'coupon_discount',
        'discount_price',
        'admin_commission',
        'vendor_commission',
        'vendor_commission_given',
        'cancelled_charge',
        'payment_status',
        'wall_amt',
        'deductedAmount',
        'refundableAmount',
        'created_at',
        'updated_at',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
