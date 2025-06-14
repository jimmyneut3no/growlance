<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use App\Models\ReferralEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function allStakes()
    {
        // Recent Activities
        $allStakes = UserStake::with(['user', 'stakingPlan'])
            ->latest()
            ->paginate(5);
        return view('admin.staking-history', compact(
            'allStakes'
        ));
    }
    public function allTransactions(){

        $allTransactions = WalletTransaction::with('user')
            ->latest()
            ->paginate(15);
        return view('admin.transactions', compact(
            'allTransactions'
        ));
}
    public function recentReferrals(){
        $recentReferrals = User::with('referrer')
            ->whereNotNull('referred_by')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'recentReferrals'
        ));
    }
} 