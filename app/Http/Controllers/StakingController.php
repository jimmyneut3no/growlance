<?php

namespace App\Http\Controllers;

use App\Models\StakingPlan;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StakingController extends Controller
{
   public function index()
{
    $stakingPlans = StakingPlan::where('is_active', true)->get();

    $activeStakes = auth()->user()->stakes()
        ->where('status', 'active')
        ->with('stakingPlan')
        ->get()
        ->map(function ($stake) {
            $progress = $this->getStakingProgress($stake->start_date, $stake->end_date);
            $stake->progress_percent = $progress['percent'];
            $stake->progress_color = $progress['color'];
            $stake->ratio = ceil($progress['percent'] / (100 / 8)); 
            return $stake;
        });

    return view('staking.index', compact('stakingPlans', 'activeStakes'));
}

        public function plans()
    {
        $stakingPlans = StakingPlan::where('is_active', true)->get();
        $activeStakes = auth()->user()->stakes()
            ->where('status', 'active')
            ->with('stakingPlan')
            ->get();

        return view('staking.plans', compact('stakingPlans', 'activeStakes'));
    }

    public function stake(Request $request, StakingPlan $plan)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $plan->min_stake, 'max:' . $plan->max_stake],
        ]);

        $user = auth()->user();
        $amount = $request->amount;

        if ($user->getBalance() < $amount) {
            return back()->with('error', 'Insufficient balance');
        }

        try {
            DB::beginTransaction();

            // Create stake
            $stake = UserStake::create([
                'user_id' => $user->id,
                'staking_plan_id' => $plan->id,
                'amount' => $amount,
                'apy' => $plan->apy,
                'daily_reward' => $plan->calculateDailyReward($amount),
                'start_date' => now(),
                'end_date' => $plan->type === 'flexible' ? null : now()->addDays($plan->lock_period),
                'status' => 'active',
            ]);

            // Create wallet transaction
            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'stake',
                'amount' => $amount,
                'status' => 'completed',
                'metadata' => [
                    'stake_id' => $stake->id,
                    'plan_id' => $plan->id,
                ],
            ]);

            DB::commit();

            return redirect()->route('staking.index')->with('success', 'Successfully staked ' . $amount . ' USDT');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process stake. Please try again.');
        }
    }

    public function unstake(UserStake $stake)
    {
        $user = auth()->user();

        if ($stake->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized action');
        }

        if (!$stake->canUnstake()) {
            return back()->with('error', 'This stake cannot be unstaked yet');
        }

        try {
            DB::beginTransaction();

            $unstakeAmount = $stake->calculateUnstakeAmount();
            $stake->update(['status' => 'early_unstaked']);

            // Create wallet transaction
            WalletTransaction::create([
                'user_id' => $user->id,
                'type' => 'unstake',
                'amount' => $unstakeAmount,
                'status' => 'completed',
                'metadata' => [
                    'stake_id' => $stake->id,
                    'original_amount' => $stake->amount,
                    'reward_amount' => $unstakeAmount - $stake->amount,
                ],
            ]);

            DB::commit();

            return redirect()->route('staking.index')->with('success', 'Successfully unstaked ' . $unstakeAmount . ' USDT');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to process unstake. Please try again.');
        }
    }

    public function history()
    {
        $stakes = auth()->user()->stakes()
            ->with('stakingPlan')
            ->latest()
            ->paginate(10);

        return view('staking.history', compact('stakes'));
    }
    public function getStakingProgress($startDate, $endDate)
{
    $start = Carbon::parse($startDate);
    $end = Carbon::parse($endDate);
    $now = Carbon::now();
    $color_green = 'rgb(29, 198, 36)';
    $color_orange = 'rgb(255, 104, 38)';
    $color_blue = '#3A82EF';
    // Prevent division by zero
    if ($start->greaterThanOrEqualTo($end)) {
        return [
            'percent' => 100,
            'color' => $color_green,
        ];
    }

    // Clamp now between start and end
    if ($now->lessThan($start)) {
        $now = $start;
    } elseif ($now->greaterThan($end)) {
        $now = $end;
    }

    $totalDuration = $end->diffInSeconds($start);
    $elapsed = $now->diffInSeconds($start);
    $percent = round(($elapsed / $totalDuration) * 100);

    // Determine color
    if ($percent >= 99) {
        $color = $color_green;
    } elseif ($percent >= 50) {
        $color = $color_orange;
    } else {
        $color = $color_blue;
    }

    return [
        'percent' => $percent,
        'color' => $color,
    ];
}
    public function processAllRewards(Request $request)
    {
        $user = auth()->user();
        $today = now()->startOfDay(); // Set to start of day for consistent comparison
        $results = [];
        
        Log::info("Starting reward processing for user", [
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
                
                Log::info("Processing stake", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'stake_status' => $stake->status,
                    'end_date' => $stake->end_date,
                    'last_reward_at' => $stake->last_reward_at
                ]);

                // Check if stake has matured
                if ($stake->end_date && $stake->end_date <= $today) {
                    $stake->update(['status' => 'completed']);
                    Log::info("Stake marked as completed", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'end_date' => $stake->end_date
                    ]);
                    $results[] = [
                        'stake_id' => $stake->id,
                        'status' => 'completed',
                        'message' => 'Stake has matured and been marked as completed'
                    ];
                }

                // Calculate all missed days
                $lastRewardDate = $stake->last_reward_at ?? $stake->created_at;
                $lastRewardDate = Carbon::parse($lastRewardDate)->startOfDay(); // Set to start of day
                
                // Ensure we're only processing if last reward was at least 24 hours ago
                if ($lastRewardDate->addDay()->isPast()) {
                    // Calculate days between dates, ensuring positive value
                    $daysSinceLastReward = max(0, $lastRewardDate->diffInDays($today, false));
                    
                    Log::info("Calculated days since last reward", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'last_reward_date' => $lastRewardDate->toDateTimeString(),
                        'today' => $today->toDateTimeString(),
                        'days_since_last_reward' => $daysSinceLastReward,
                        'is_past_24h' => true
                    ]);
                    
                    if ($daysSinceLastReward > 0) {
                        $totalReward = 0;
                        $currentDate = Carbon::parse($lastRewardDate);
                        $processedDays = 0;
                        
                        Log::info("Starting daily reward processing", [
                            'user_id' => $user->id,
                            'stake_id' => $stake->id,
                            'start_date' => $currentDate->toDateString(),
                            'daily_reward' => $stake->daily_reward
                        ]);
                        
                        // Process each missed day
                        for ($i = 0; $i < $daysSinceLastReward; $i++) {
                            $currentDate->addDay();
                            
                            // Skip if stake has ended
                            if ($currentDate > $stake->end_date) {
                                Log::info("Skipping future dates beyond stake end date", [
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
                            
                            Log::info("Creating daily reward transaction", [
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
                                'created_at' => $currentDate,
                                'metadata' => [
                                    'stake_id' => $stake->id,
                                    'plan_id' => $stake->staking_plan_id,
                                    'reward_date' => $currentDate->toDateString(),
                                ],
                            ]);
                        }
                        
                        // Update stake only if rewards were added
                        if ($totalReward > 0) {
                            Log::info("Updating stake with new rewards", [
                                'user_id' => $user->id,
                                'stake_id' => $stake->id,
                                'total_reward' => $totalReward,
                                'processed_days' => $processedDays
                            ]);
                            
                            $stake->update([
                                'total_reward' => $stake->total_reward + $totalReward,
                                'last_reward_at' => $today,
                            ]);
                            
                            $results[] = [
                                'stake_id' => $stake->id,
                                'status' => 'success',
                                'message' => "Processed {$processedDays} days of rewards",
                                'total_reward' => $totalReward
                            ];
                        } else {
                            Log::info("No rewards to add for stake", [
                                'user_id' => $user->id,
                                'stake_id' => $stake->id
                            ]);
                        }
                    }
                } else {
                    Log::info("Skipping stake - less than 24 hours since last reward", [
                        'user_id' => $user->id,
                        'stake_id' => $stake->id,
                        'last_reward_date' => $lastRewardDate->toDateTimeString(),
                        'hours_since_last_reward' => $lastRewardDate->diffInHours(now())
                    ]);
                }

                DB::commit();
                Log::info("Successfully processed stake rewards", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'total_reward' => $totalReward ?? 0,
                    'processed_days' => $processedDays ?? 0
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Failed to process rewards for stake", [
                    'user_id' => $user->id,
                    'stake_id' => $stake->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                $results[] = [
                    'stake_id' => $stake->id,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        Log::info("Completed reward processing for user", [
            'user_id' => $user->id,
            'total_stakes_processed' => count($activeStakes),
            'results' => $results
        ]);

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }
}