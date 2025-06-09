<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStake;
use App\Models\WalletTransaction;
use App\Models\ReferralEarning;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $query = User::withCount(['stakes', 'referrals'])
            ->withSum('stakes', 'amount');

        // Search functionality
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = request('status')) {
            $query->where('is_active', $status === 'active');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['referrer', 'referrals']);
        
        $stats = [
            'total_staked' => $user->stakes()->sum('amount'),
            'active_stakes' => $user->stakes()->where('status', 'active')->count(),
            'total_earnings' => $user->getTotalEarnings(),
            'referral_earnings' => $user->getReferralEarnings(),
            'total_referrals' => $user->getTotalReferralsCount(),
        ];

        $stakes = $user->stakes()
            ->with('stakingPlan')
            ->latest()
            ->paginate(10);

        $transactions = $user->walletTransactions()
            ->latest()
            ->paginate(10);

        $referralEarnings = $user->referralEarnings()
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.users.show', compact(
            'user',
            'stats',
            'stakes',
            'transactions',
            'referralEarnings'
        ));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'is_admin' => ['boolean'],
            'kyc_status' => ['required', 'in:pending,verified,rejected'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);

        return back()->with('success', 'Admin status updated successfully');
    }

    public function updateKycStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'kyc_status' => ['required', 'in:pending,verified,rejected'],
            'kyc_data' => ['nullable', 'array'],
        ]);

        $user->update($validated);

        return back()->with('success', 'KYC status updated successfully');
    }

    public function destroy(User $user)
    {
        // Prevent deleting the last admin
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
} 