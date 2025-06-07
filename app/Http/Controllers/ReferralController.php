<?php

namespace App\Http\Controllers;

use App\Models\ReferralEarning;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $referralLink = $user->getReferralLink();
        
        // Get referrals by level
        $level1Referrals = $user->getLevel1Referrals()->withCount('stakes')->get();
        $level2Referrals = $user->getLevel2Referrals()->withCount('stakes')->get();
        $level3Referrals = $user->getLevel3Referrals()->withCount('stakes')->get();
        
        $earnings = [
            'total' => $user->getReferralEarnings(),
            'pending' => $user->getPendingReferralEarnings(),
            'by_level' => [
                1 => [
                    'total' => $user->getReferralEarningsByLevel(1),
                    'pending' => $user->getPendingReferralEarningsByLevel(1),
                    'referrals' => $level1Referrals->count(),
                ],
                2 => [
                    'total' => $user->getReferralEarningsByLevel(2),
                    'pending' => $user->getPendingReferralEarningsByLevel(2),
                    'referrals' => $level2Referrals->count(),
                ],
                3 => [
                    'total' => $user->getReferralEarningsByLevel(3),
                    'pending' => $user->getPendingReferralEarningsByLevel(3),
                    'referrals' => $level3Referrals->count(),
                ],
            ],
        ];

        $recentEarnings = $user->referralEarnings()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('referral.index', compact(
            'referralLink',
            'level1Referrals',
            'level2Referrals',
            'level3Referrals',
            'earnings',
            'recentEarnings'
        ));
    }

    public function withdraw()
    {
        $user = auth()->user();
        $pendingEarnings = $user->getPendingReferralEarnings();

        if ($pendingEarnings <= 0) {
            return back()->with('error', 'No pending earnings to withdraw');
        }

        try {
            // Create withdrawal transaction
            $transaction = $user->walletTransactions()->create([
                'type' => 'referral',
                'amount' => $pendingEarnings,
                'status' => 'completed',
                'metadata' => [
                    'source' => 'referral_earnings',
                ],
            ]);

            // Mark referral earnings as paid
            $user->referralEarnings()
                ->where('status', 'pending')
                ->update(['status' => 'paid']);

            return redirect()->route('wallet.index')
                ->with('success', 'Referral earnings withdrawn to main balance submitted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to process withdrawal. Please try again.');
        }
    }

    public function statistics()
    {
        $user = auth()->user();
        
        $stats = [
            'total_referrals' => $user->referrals()->count(),
            'active_referrals' => $user->referrals()
                ->whereHas('stakes', function ($query) {
                    $query->where('status', 'active');
                })
                ->count(),
            'total_earnings' => $user->getReferralEarnings(),
            'pending_earnings' => $user->getPendingReferralEarnings(),
            'earnings_by_level' => [
                1 => $user->referralEarnings()->byLevel(1)->sum('amount'),
                2 => $user->referralEarnings()->byLevel(2)->sum('amount'),
                3 => $user->referralEarnings()->byLevel(3)->sum('amount'),
            ],
        ];

        return view('referral.statistics', compact('stats'));
    }

    public function referrals()
    {
        $user = auth()->user();
        $level1Referrals = $user->getLevel1Referrals()
            ->withCount(['stakes', 'referrals'])
            ->withSum('stakes', 'amount')
            ->latest()
            ->paginate(20);

        return view('referral.referrals', compact('level1Referrals'));
    }

    public function earnings()
    {
        $earnings = auth()->user()->referralEarnings()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('referral.earnings', compact('earnings'));
    }
} 