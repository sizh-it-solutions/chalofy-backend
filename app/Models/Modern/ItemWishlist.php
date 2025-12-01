<?php

namespace App\Models\Modern;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modern\Item;

class ItemWishlist extends Model
{
    use HasFactory;

    protected $table = 'rental_item_wishlists';

    protected $fillable = [
        'user_id',
        'item_id',
        'module',
    ];

    protected $casts = [
        'user_id' => 'string',
        'item_id' => 'string',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}
