<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pool extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'slug',
        'visibility',
        'entry_fee_cents',
        'max_entries',
        'locks_at',
        'scoring_complete',
    ];

    protected $casts = [
        'entry_fee_cents' => 'integer',
        'max_entries' => 'integer',
        'locks_at' => 'datetime',
        'scoring_complete' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function plays(): HasMany
    {
        return $this->hasMany(Play::class);
    }
}
