<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use App\Models\StakingPlan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessStakingRewardsOnLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $now = now();
        $today = $now->startOfDay();
        
        Log::info("Starting reward processing on login", [
            'user_id' => $user->id,
            'timestamp' => $now->toDateTimeString(),
            'today' => $today->toDateTimeString()
        ]);
        
        // Get all active stakes for the user with their staking plan
        $activeStakes = UserStake::with('stakingPlan')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        Log::info("Found active stakes for processing", [
            'user_id' => $user->id,
            'stake_count' => $activeStakes->count(),
            'stake_ids' => $activeStakes->pluck('id')->toArray()
        ]);

        foreach ($activeStakes as $stake) {
            try {
                DB::beginTransaction();

                // Get the lock_period from the staking plan
                $lockPeriod = $stake->stakingPlan->lock_period;
                $stakeEndDate = Carbon::parse($stake->created_at)->addDays($lockPeriod)->startOfDay();

                Log::info("Processing stake on login", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'stake_status' => $stake->status,
                    'created_at' => $stake->created_at,
                    'calculated_end_date' => $stakeEndDate->toDateString(),
                    'lock_period' => $lockPeriod,
                    'daily_reward' => $stake->daily_reward,
                    'staking_plan_id' => $stake->staking_plan_id
                ]);

                // Check if stake has matured
                if ($stakeEndDate <= $today) {
                    $stake->update(['status' => 'completed', 'end_date' => $stakeEndDate]);
                    Log::info("Stake marked as completed on login", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'end_date' => $stakeEndDate->toDateString()
                    ]);
                    DB::commit();
                    continue;
                }

                // Calculate expected reward days and actual received rewards
                $stakeStartDate = Carbon::parse($stake->created_at)->startOfDay();
                $daysSinceStakeStart = $stakeStartDate->diffInDays($today);
                $expectedRewardDays = min($daysSinceStakeStart, $lockPeriod);
                
                // Count actual rewards received for this stake
                $actualRewardDays = WalletTransaction::where('user_id', $user->id)
                    ->where('type', 'reward')
                    ->whereJsonContains('metadata->stake_id', $stake->id)
                    ->count();
                
                Log::info("Reward day calculations", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'stake_start_date' => $stakeStartDate->toDateString(),
                    'days_since_stake_start' => $daysSinceStakeStart,
                    'lock_period' => $lockPeriod,
                    'expected_reward_days' => $expectedRewardDays,
                    'actual_reward_days' => $actualRewardDays
                ]);

                // Calculate missing rewards
                $missingRewardDays = $expectedRewardDays - $actualRewardDays;
                
                if ($missingRewardDays <= 0) {
                    Log::info("No missing rewards for stake", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'missing_reward_days' => $missingRewardDays
                    ]);
                    DB::commit();
                    continue;
                }

                Log::info("Processing missing rewards", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'missing_reward_days' => $missingRewardDays,
                    'max_possible_missing_days' => $lockPeriod - $actualRewardDays
                ]);

                $totalReward = 0;
                $processedDays = 0;
                
                // Process each missing reward day
                for ($day = 1; $day <= $missingRewardDays; $day++) {
                    $rewardDate = $stakeStartDate->copy()->addDays($actualRewardDays + $day);
                    
                    // Extra safety check - shouldn't be needed due to earlier calculations
                    if ($rewardDate > $stakeEndDate) {
                        Log::warning("Attempted to process reward beyond stake end date", [
                            'user_id' => $user->id,
                            'stake_id' => $stake->id,
                            'reward_date' => $rewardDate->toDateString(),
                            'stake_end_date' => $stakeEndDate->toDateString()
                        ]);
                        continue;
                    }
                    
                    $dailyReward = $stake->daily_reward;
                    $totalReward += $dailyReward;
                    $processedDays++;
                    
                    Log::info("Creating reward transaction", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'reward_date' => $rewardDate->toDateString(),
                        'daily_reward' => $dailyReward,
                        'day_number' => $actualRewardDays + $day,
                        'total_days_so_far' => $actualRewardDays + $day
                    ]);
                    
                    WalletTransaction::create([
                        'user_id' => $user->id,
                        'type' => 'reward',
                        'amount' => $dailyReward,
                        'status' => 'completed',
                        'created_at' => $rewardDate,
                        'metadata' => [
                            'stake_id' => $stake->id,
                            'plan_id' => $stake->staking_plan_id,
                            'reward_date' => $rewardDate->toDateString(),
                            'day_number' => $actualRewardDays + $day,
                            'lock_period' => $lockPeriod,
                            'total_days_so_far' => $actualRewardDays + $day
                        ],
                    ]);
                }
                
                // Update stake only if rewards were added
                if ($totalReward > 0) {
                    Log::info("Updating stake with new rewards", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'total_reward_added' => $totalReward,
                        'processed_days' => $processedDays,
                        'new_total_reward' => $stake->total_reward + $totalReward,
                        'new_last_reward_at' => $now,
                        'remaining_lock_period' => $lockPeriod - ($actualRewardDays + $processedDays)
                    ]);
                    
                    $stake->update([
                        'total_reward' => $stake->total_reward + $totalReward,
                        'last_reward_at' => $now,
                        'end_date' => $stakeEndDate // Ensure end_date is always set
                    ]);
                }

                DB::commit();
                Log::info("Successfully processed stake rewards", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'total_reward_added' => $totalReward,
                    'processed_days' => $processedDays,
                    'total_reward_days_so_far' => $actualRewardDays + $processedDays,
                    'remaining_days' => $lockPeriod - ($actualRewardDays + $processedDays)
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Failed to process rewards for stake", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'staking_plan_id' => $stake->staking_plan_id ?? null
                ]);
            }
        }

        Log::info("Completed reward processing on login", [
            'user_id' => $user->id,
            'total_stakes_processed' => count($activeStakes),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}