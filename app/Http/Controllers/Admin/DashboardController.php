<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use App\Models\ReferralEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // General Statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::whereHas('stakes', function ($query) {
                $query->where('status', 'active');
            })->count(),
            'total_stakes' => UserStake::where('status', 'active')->count(),
            'total_staked_amount' => UserStake::where('status', 'active')->sum('amount'),
            'total_referral_earnings' => ReferralEarning::sum('amount'),
            'pending_referral_earnings' => ReferralEarning::where('status', 'pending')->sum('amount'),
            'total_transactions' => WalletTransaction::count(),
            'total_deposits' => WalletTransaction::where('type', 'deposit')->where('status', 'completed')->sum('amount'),
            'total_withdrawals' => WalletTransaction::where('type', 'withdrawal')->where('status', 'completed')->sum('amount'),
        ];

        // Recent Activities
        $recentStakes = UserStake::with(['user', 'stakingPlan'])
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = WalletTransaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentReferrals = User::with('referrer')
            ->whereNotNull('referred_by')
            ->latest()
            ->take(5)
            ->get();

        // Monthly Statistics
        $monthlyStats = [
            'new_users' => User::whereMonth('created_at', now()->month)->count(),
            'new_stakes' => UserStake::whereMonth('created_at', now()->month)->count(),
            'new_deposits' => WalletTransaction::where('type', 'deposit')
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
            'new_withdrawals' => WalletTransaction::where('type', 'withdrawal')
                ->where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentStakes',
            'recentTransactions',
            'recentReferrals',
            'monthlyStats'
        ));
    }
} 