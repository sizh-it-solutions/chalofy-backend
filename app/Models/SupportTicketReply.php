<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id', 
        'user_id', 
        'is_admin_reply', 
        'message', 
        'reply_status', 
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'thread_id' => 'string',
        'user_id' => 'string',
        'reply_status' => 'string',
        'is_admin_reply' => 'string',
    ];
   
    public function thread()
    {
        return $this->belongsTo(SupportTicket::class, 'thread_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function AppUser()
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }

}
