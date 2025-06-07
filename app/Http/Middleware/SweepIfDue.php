<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SweepIfDue
{
    public function handle(Request $request, Closure $next)
    {
       if (auth()->check()) {
        $user = $request->user();
            $lastSweep = $user->last_sweep_at ?? now()->subMinutes(10);
            if (now()->diffInMinutes($lastSweep) >= 5) {
                try {               
                   $sweep = app(\App\Services\BlockchainService::class)->sweep($user);
                   if($sweep['success']){
                        if (isset($sweep['data']['type']) && $sweep['data']['type'] === 'deposit') {
                            session()->flash('success', 'Your wallet deposit was successful!');
                        } elseif (isset($sweep['data']['type']) && $sweep['data']['type'] === 'withdrawal') {
                            session()->flash('success', 'Your withdrawal process has been completed!');
                        }
                   }         
                } catch (\Exception $e) {
                    Log::error("Sweep failed: " . $e->getMessage());
                }
            }
        }
        return $next($request);
    }
}
