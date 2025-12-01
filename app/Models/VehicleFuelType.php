<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleFuelType extends Model
{
    use HasFactory;

    protected $table = 'vehicle_fuel_type';

    protected $fillable = [
        'name',
        'status',
        'module',
    ];
     const STATUS_SELECT = [
        1 => 'Active',
        0 => 'Inactive',
    ];
}
