<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessStakingRewardsOnLogin
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $today = now()->startOfDay(); // Set to start of day for consistent comparison
        
        Log::info("Starting reward processing on login", [
            'user_id' => $user->id,
            'timestamp' => $today->toDateTimeString()
        ]);
        
        // Get all active stakes for the user
        $activeStakes = UserStake::where('user_id', $user->id)
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

                Log::info("Processing stake on login", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'stake_status' => $stake->status,
                    'end_date' => $stake->end_date,
                    'last_reward_at' => $stake->last_reward_at
                ]);

                // Check if stake has matured
                if ($stake->end_date && $stake->end_date <= $today) {
                    $stake->update(['status' => 'completed']);
                    Log::info("Stake marked as completed on login", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'end_date' => $stake->end_date
                    ]);
                }

                // Calculate missed days (max 5 days lookback)
                $lastRewardDate = $stake->last_reward_at ?? $stake->created_at;
                $lastRewardDate = Carbon::parse($lastRewardDate)->startOfDay(); // Set to start of day
                
                // Ensure we're only processing if last reward was at least 24 hours ago
                if ($lastRewardDate->addDay()->isPast()) {
                    // Calculate days between dates, ensuring positive value and max 5 days
                    $daysSinceLastReward = min(max(0, $lastRewardDate->diffInDays($today, false)), 5);
                    
                    Log::info("Calculated days since last reward on login", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'last_reward_date' => $lastRewardDate->toDateTimeString(),
                        'today' => $today->toDateTimeString(),
                        'days_since_last_reward' => $daysSinceLastReward,
                        'is_past_24h' => true
                    ]);
                    
                    // Only process if rewards are due
                    if ($daysSinceLastReward > 0) {
                        $totalReward = 0;
                        $currentDate = Carbon::parse($lastRewardDate);
                        $processedDays = 0;
                        
                        Log::info("Starting daily reward processing on login", [
                            'user_id' => $user->id,
                            'stake_id' => $stake->id,
                            'start_date' => $currentDate->toDateString(),
                            'daily_reward' => $stake->daily_reward
                        ]);
                        
                        // Process each missed day (catch-up)
                        for ($i = 0; $i < $daysSinceLastReward; $i++) {
                            $currentDate->addDay();
                            
                            // Skip if stake has ended
                            if ($currentDate > $stake->end_date) {
                                Log::info("Skipping future dates beyond stake end date on login", [
                                    'user_id' => $user->id,
                                    'stake_id' => $stake->id,
                                    'current_date' => $currentDate->toDateString(),
                                    'end_date' => $stake->end_date
                                ]);
                                break;
                            }
                            
                            $dailyReward = $stake->daily_reward;
                            $totalReward += $dailyReward;
                            $processedDays++;
                            
                            Log::info("Creating daily reward transaction on login", [
                                'user_id' => $user->id,
                                'stake_id' => $stake->id,
                                'date' => $currentDate->toDateString(),
                                'daily_reward' => $dailyReward
                            ]);
                            
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
                            Log::info("Updating stake with new rewards on login", [
                                'user_id' => $user->id,
                                'stake_id' => $stake->id,
                                'total_reward' => $totalReward,
                                'processed_days' => $processedDays
                            ]);
                            
                            $stake->update([
                                'total_reward' => $stake->total_reward + $totalReward,
                                'last_reward_at' => $today,
                            ]);
                        } else {
                            Log::info("No rewards to add for stake on login", [
                                'user_id' => $user->id,
                                'stake_id' => $stake->id
                            ]);
                        }
                    }
                } else {
                    Log::info("Skipping stake on login - less than 24 hours since last reward", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'last_reward_date' => $lastRewardDate->toDateTimeString(),
                        'hours_since_last_reward' => $lastRewardDate->diffInHours(now())
                    ]);
                }

                DB::commit();
                Log::info("Successfully processed stake rewards on login", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'total_reward' => $totalReward ?? 0,
                    'processed_days' => $processedDays ?? 0
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Failed to process rewards for user on login", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info("Completed reward processing on login", [
            'user_id' => $user->id,
            'total_stakes_processed' => count($activeStakes)
        ]);
    }
}
