<?php

namespace App\Http\Controllers;
use App\Models\StakingPlan;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home(Request $request){
         $stakingPlans = StakingPlan::where('is_active', true)->get();
        return view('home', compact('stakingPlans'));
    }
    public function contact(Request $request){
        // $StakingPlan = StakingPlan::all();
        return view('contact');
    }
    public function stakingPlans(Request $request){
         $stakingPlans = StakingPlan::where('is_active', true)->get();
        return view('staking-plans', compact('stakingPlans'));
    }
}