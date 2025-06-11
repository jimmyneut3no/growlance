<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class UserStake extends Model
{
    protected $fillable = [
        'user_id',
        'staking_plan_id',
        'amount',
        'apy',
        'daily_reward',
        'total_reward',
        'start_date',
        'end_date',
        'last_reward_at',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:6',
        'apy' => 'decimal:2',
        'daily_reward' => 'decimal:6',
        'total_reward' => 'decimal:6',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'last_reward_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($stake) {
            // Calculate referral earnings for 3 levels
            // $settings = SystemSetting::where('group', 'referral')->get()->pluck('value', 'key')->toArray();
            $user = $stake->user;
            $referrer = $user->referrer;
            $level = 1;
            $settings = SystemSetting::where('group', 'referral')->get()->pluck('value', 'key')->toArray();
            Log::info('Settings:', $settings);

            $referralPercentages = [
                1 => 4,
                2 => 2,
                3 => 1,
            ];

            // Update values from settings if available
            // foreach ($referralPercentages as $level => $default) {
            //     if (isset($settings[$level])) {
            //         $referralPercentages[$level] = (float) $settings[$level];
            //     }
            // }
            while ($referrer && $level <= 3) {
                $earning = $stake->amount * ($referralPercentages[$level] / 100);
                
                ReferralEarning::create([
                    'user_id' => $user->id,
                    'referrer_id' => $referrer->id,
                    'amount' => $earning,
                    'level' => $level,
                    'status' => 'pending',
                    'source_type' => 'stake',
                    'source_id' => $stake->id,
                ]);

                $referrer = $referrer->referrer;
                $level++;
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stakingPlan(): BelongsTo
    {
        return $this->belongsTo(StakingPlan::class);
    }

    public function isMature(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return now()->isAfter($this->end_date);
    }

    public function calculateCurrentReward(): float
    {
        if (!$this->last_reward_at) {
            return 0;
        }

        $days = now()->diffInDays($this->last_reward_at);
        return $this->daily_reward * $days;
    }

    public function canUnstake(): bool
    {
        if ($this->stakingPlan->type === 'flexible') {
            return false;
        }

        return $this->isMature();
    }

    public function calculateUnstakeAmount(): float
    {
        if ($this->canUnstake()) {
            return $this->amount + $this->calculateCurrentReward();
        }

        $penalty = $this->stakingPlan->calculateEarlyUnstakePenalty($this->amount);
        return $this->amount - $penalty;
    }
} 