<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pick extends Model
{
    protected $fillable = [
        'play_id',
        'fight_id',
        'selection',
        'confidence',
        'swimmies_used',
        'points_earned',
    ];

    protected $casts = [
        'confidence' => 'integer',
        'swimmies_used' => 'boolean',
        'points_earned' => 'float',
    ];

    public function play(): BelongsTo
    {
        return $this->belongsTo(Play::class);
    }

    public function fight(): BelongsTo
    {
        return $this->belongsTo(Fight::class);
    }
}
