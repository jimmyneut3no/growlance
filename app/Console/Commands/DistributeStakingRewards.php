<?php

namespace App\Console\Commands;

use App\Models\UserStake;
use App\Models\WalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DistributeStakingRewards extends Command
{
    protected $signature = 'staking:distribute-rewards';
    protected $description = 'Distribute daily rewards to active stakes';

    public function handle()
    {
        $this->info('Starting daily rewards distribution...');

        $activeStakes = UserStake::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('last_reward_at')
                    ->orWhereDate('last_reward_at', '<', now());
            })
            ->get();

        $this->info("Found {$activeStakes->count()} stakes to process");

        foreach ($activeStakes as $stake) {
            try {
                DB::beginTransaction();

                $reward = $stake->daily_reward;
                $stake->update([
                    'total_reward' => $stake->total_reward + $reward,
                    'last_reward_at' => now(),
                ]);

                // Create reward transaction
                WalletTransaction::create([
                    'user_id' => $stake->user_id,
                    'type' => 'reward',
                    'amount' => $reward,
                    'status' => 'completed',
                    'metadata' => [
                        'stake_id' => $stake->id,
                        'plan_id' => $stake->staking_plan_id,
                    ],
                ]);

                DB::commit();
                $this->info("Processed stake #{$stake->id} - Reward: {$reward} USDT");
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Failed to process stake #{$stake->id}: {$e->getMessage()}");
            }
        }

        $this->info('Daily rewards distribution completed');
    }
} 