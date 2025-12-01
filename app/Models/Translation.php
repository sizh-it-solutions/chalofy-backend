<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'translatable_id',
        'translatable_type',
        'locale',
        'key',
        'value',
    ];

    /**
     * Get the owning translatable model (Vehicle, Make, Model, etc.).
     */
    public function translatable()
    {
        return $this->morphTo();
    }

    /**
     * Scope: Filter translations for a specific locale.
     */
    public function scopeForLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Scope: Filter translations for a specific key (e.g., 'title').
     */
    public function scopeForKey($query, $key)
    {
        return $query->where('key', $key);
    }
}
