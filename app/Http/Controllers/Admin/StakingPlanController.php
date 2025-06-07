<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StakingPlan;
use Illuminate\Http\Request;

class StakingPlanController extends Controller
{
    public function index()
    {
        $stakingPlans = StakingPlan::withCount('stakes')
            ->withSum('stakes', 'amount')
            ->latest()
            ->paginate(20);

        return view('admin.staking-plans.index', compact('stakingPlans'));
    }

    public function create()
    {
        return view('admin.staking-plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:fixed,flexible'],
            'apy' => ['required', 'numeric', 'min:0', 'max:100'],
            'lock_period' => ['required', 'integer', 'min:1'],
            'min_stake' => ['required', 'numeric', 'min:0'],
            'max_stake' => ['required', 'numeric', 'min:0', 'gt:min_stake'],
            'early_unstake_penalty' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        StakingPlan::create($validated);

        return redirect()->route('admin.staking-plans.index')
            ->with('success', 'Staking plan created successfully');
    }

    public function edit(StakingPlan $stakingPlan)
    {
        return view('admin.staking-plans.form', compact('stakingPlan'));
    }

    public function update(Request $request, StakingPlan $stakingPlan)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:fixed,flexible'],
            'apy' => ['required', 'numeric', 'min:0', 'max:100'],
            'lock_period' => ['required', 'integer', 'min:1'],
            'min_stake' => ['required', 'numeric', 'min:0'],
            'max_stake' => ['required', 'numeric', 'min:0', 'gt:min_stake'],
            'early_unstake_penalty' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['boolean'],
        ]);

        $stakingPlan->update($validated);

        return redirect()->route('admin.staking-plans.index')
            ->with('success', 'Staking plan updated successfully');
    }

    public function toggleActive(StakingPlan $stakingPlan)
    {
        $stakingPlan->update(['is_active' => !$stakingPlan->is_active]);

        return back()->with('success', 'Staking plan status updated successfully');
    }
} 