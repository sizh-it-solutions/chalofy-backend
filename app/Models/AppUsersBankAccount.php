<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AppUsersBankAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_users_bank_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'account_name',
        'bank_name',
        'branch_name',
        'account_number',
        'iban',
        'swift_code',
    ];

    protected $casts = [
        'user_id' => 'string'
    
    
    ];
    /**
     * Get the user that owns the bank account.
     */
    public function user()
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }
}
