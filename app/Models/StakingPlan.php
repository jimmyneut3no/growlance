<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StakingPlan extends Model
{
    protected $fillable = [
        'name',
        'type',
        'apy',
        'lock_period',
        'min_stake',
        'max_stake',
        'early_unstake_penalty',
        'is_active',
    ];

    protected $casts = [
        'apy' => 'decimal:2',
        'min_stake' => 'decimal:6',
        'max_stake' => 'decimal:6',
        'early_unstake_penalty' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function stakes(): HasMany
    {
        return $this->hasMany(UserStake::class);
    }

    // public function calculateDailyReward(float $amount): float
    // {
    //     return ($amount * $this->apy) / (365 * 100);
    // }
    public function calculateDailyReward(float $amount): float
    {
        
        // return ((($amount * $this->apy/100) * $this->lock_period) - $amount)/$this->lock_period;
        return ($amount * $this->apy/100);

    }
    public function calculateTotalReward(float $amount, int $days): float
    {
        return $this->calculateDailyReward($amount) * $days;
    }

    public function calculateEarlyUnstakePenalty(float $amount): float
    {
        return ($amount * $this->early_unstake_penalty) / 100;
    }
} 