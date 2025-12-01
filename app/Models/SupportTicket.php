<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{AppUser};
class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // User ID creating the thread
        'title', // Title of the support ticket thread
        'description', // Description of the support ticket thread
        'thread_id',
        'thread_status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'user_id' => 'string',
        'thread_status' => 'string',
    ];

    // Define the relationship with support ticket replies
    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'thread_id');
    }

    // Define the relationship with the user who created the ticket
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function appUser()
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }

}
