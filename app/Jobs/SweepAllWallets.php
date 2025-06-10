<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SweepAllWallets implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        User::chunk(200, function ($users) {
            foreach ($users as $user) {
                $this->sweepUserWallet($user);
            }
        });
    }

    protected function sweepUserWallet(User $user)
    {
        try {
            $response = app('blockchainService')->sweep($user);
            Log::info('Sweep completed', [
                'user_id' => $user->id,
                'response' => $response
            ]);
        } catch (\Exception $e) {
            Log::error('Sweep failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            // Optionally implement retry logic here
        }
    }
}
