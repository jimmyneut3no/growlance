<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessStakingRewardsOnLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $today = now();
        
        // Get all active stakes for the user
        $activeStakes = UserStake::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        foreach ($activeStakes as $stake) {
            try {
                DB::beginTransaction();

                // Calculate missed days (max 5 days lookback)
                $lastRewardDate = $stake->last_reward_at ?? $stake->created_at;
                $daysSinceLastReward = min($today->diffInDays($lastRewardDate), 5);
                
                // Only process if rewards are due
                if ($daysSinceLastReward > 0) {
                    $totalReward = 0;
                    $currentDate = Carbon::parse($lastRewardDate);
                    
                    // Process each missed day (catch-up)
                    for ($i = 0; $i < $daysSinceLastReward; $i++) {
                        $currentDate->addDay();
                        
                        // Skip if stake has ended
                        if ($currentDate > $stake->end_date) {
                            break;
                        }
                        
                        $dailyReward = $stake->daily_reward;
                        $totalReward += $dailyReward;
                        
                        // Create individual transaction for each day
                        WalletTransaction::create([
                            'user_id' => $user->id,
                            'type' => 'reward',
                            'amount' => $dailyReward,
                            'status' => 'completed',
                            'created_at' => $currentDate, // Backdate transaction
                            'metadata' => [
                                'stake_id' => $stake->id,
                                'plan_id' => $stake->staking_plan_id,
                                'reward_date' => $currentDate->toDateString(),
                            ],
                        ]);
                    }
                    
                    // Update stake only if rewards were added
                    if ($totalReward > 0) {
                        $stake->update([
                            'total_reward' => $stake->total_reward + $totalReward,
                            'last_reward_at' => $today,
                        ]);
                        
                        // Log success
                        logger()->info("Processed rewards for user {$user->id}", [
                            'stake_id' => $stake->id,
                            'days_processed' => $daysSinceLastReward,
                            'total_reward' => $totalReward,
                        ]);
                    }
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                logger()->error("Failed to process rewards for user {$user->id}", [
                    'stake_id' => $stake->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
