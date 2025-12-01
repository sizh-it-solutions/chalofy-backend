<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public $table = 'contact_us';


    protected $fillable = [
        'id',
        'tittle',
        'description',
        'user',
        'status',
        'created_at',
        'updated_at',
    ];
    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'user'); 
    }

}
