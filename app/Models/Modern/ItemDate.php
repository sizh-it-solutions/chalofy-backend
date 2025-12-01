<?php

namespace App\Models\Modern;

use Illuminate\Database\Eloquent\Model;

class ItemDate extends Model
{
    protected $table = 'rental_item_dates';

    protected $fillable = [
        'item_id',
        'status',
        'price',
        'additional_hour',
        'min_stay',
        'min_day',
        'date',
        'type',
        'module',
        'booking_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'item_id' => 'string',
        'booking_id' => 'string',
        'price' => 'string',
        'min_stay' => 'string',
        'min_day' => 'string',
        'range_index' => 'string',
    ];

    public function rentalItem()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}





