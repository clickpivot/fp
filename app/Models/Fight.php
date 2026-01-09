<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fight extends Model
{
    protected $fillable = [
        'event_id',
        'bout_order',
        'fighter_red',
        'fighter_blue',
        'weight_class',
        'odds_red',
        'odds_blue',
        'is_main_event',
        'is_co_main_event',
        'swimmies_allowed',
        'winner',
        'method',
        'ending_round',
        'ending_time',
        'status',
        'api_external_id',
    ];

    protected $casts = [
        'odds_red' => 'integer',
        'odds_blue' => 'integer',
        'is_main_event' => 'boolean',
        'is_co_main_event' => 'boolean',
        'swimmies_allowed' => 'boolean',
        'ending_round' => 'integer',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class);
    }
}
