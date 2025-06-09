<?php

namespace App\Http\Controllers;

use App\Models\UserStake;
use App\Models\SystemSetting;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's statistics
        $stats = [
            'balance' => $user->getBalance(),
            'staked_balance' => $user->getStakedBalance(),
            'total_earnings' => $user->getTotalEarnings(),
            'referral_earnings' => $user->getReferralEarnings(),
        ];

        // Get active stakes
        $activeStakes = $user->stakes()
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

        // Get recent transactions
        $recentTransactions = $user->walletTransactions()
            ->latest()
            ->take(5)
            ->get();

        // Get staking distribution
        $stakingDistribution = DB::table('user_stakes')
            ->join('staking_plans', 'user_stakes.staking_plan_id', '=', 'staking_plans.id')
            ->where('user_stakes.user_id', $user->id)
            ->where('user_stakes.status', 'active')
            ->select(
                'staking_plans.name as plan',
                DB::raw('SUM(user_stakes.amount) as amount')
            )
            ->groupBy('staking_plans.name')
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'activeStakes',
            'recentTransactions',
            'stakingDistribution'
        ));
    }

    public function announcements()
    {
        $announcements = SystemSetting::where('key', 'like', 'announcement.%')
            ->where('is_public', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($setting) {
                return [
                    'title' => str_replace('announcement.', '', $setting->key),
                    'content' => $setting->value,
                    'date' => $setting->created_at,
                ];
            });

        return view('dashboard.announcements', compact('announcements'));
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
} 