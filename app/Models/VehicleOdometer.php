<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOdometer extends Model
{
    use HasFactory;

    protected $table = 'vehicle_odometer';
 const STATUS_SELECT = [
        1 => 'Active',
        0 => 'Inactive',
    ];
    protected $fillable = [
        'name',
        'status',
        'module',
    ];
}
