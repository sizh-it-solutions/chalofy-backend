<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{EmailNotificationMapping};

class EmailType extends Model
{
    protected $table = 'email_type';
    protected $fillable = ['name'];
    protected $primaryKey = 'id';

    public function emailNotificationMappings()
    {
        return $this->hasMany(EmailNotificationMapping::class, 'email_type_id');
    }
}
