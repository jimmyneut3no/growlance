<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StakeReward extends Model
{
    protected $fillable = [
        'user_id',
        'stake_id',
        'amount',
        'type',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stake(): BelongsTo
    {
        return $this->belongsTo(UserStake::class, 'stake_id');
    }
} 