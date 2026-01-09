<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'starts_at',
        'status',
        'api_external_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
    ];

    public function fights(): HasMany
    {
        return $this->hasMany(Fight::class)->orderBy('bout_order');
    }

    public function pools(): HasMany
    {
        return $this->hasMany(Pool::class);
    }
}
