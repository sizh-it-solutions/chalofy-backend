<?php

namespace App\Models\Modern;

use Illuminate\Database\Eloquent\Model;
use App\Models\Modern\{Item};

class ItemVehicle extends Model
{

    protected $table = 'rental_item_vehicle';
    public $timestamps = false;

    protected $fillable = [
        'item_id',
        'year',
        'odometer',
        'transmission',
        'number_of_seats',
        'fuel_type_id'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
