<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Play extends Model
{
    protected $fillable = [
        'pool_id',
        'user_id',
        'total_score',
        'rank',
    ];

    protected $casts = [
        'total_score' => 'float',
        'rank' => 'integer',
    ];

    public function pool(): BelongsTo
    {
        return $this->belongsTo(Pool::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class);
    }
}
