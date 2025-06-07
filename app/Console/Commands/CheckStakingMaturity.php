<?php

// namespace App\Console\Commands;

// use App\Models\UserStake;
// use App\Models\WalletTransaction;
// use Illuminate\Console\Command;
// use Illuminate\Support\Facades\DB;

// class CheckStakingMaturity extends Command
// {
//     protected $signature = 'staking:check-maturity';
//     protected $description = 'Check and process matured stakes';

//     public function handle()
//     {
//         $this->info('Starting staking maturity check...');

//         $maturedStakes = UserStake::where('status', 'active')
//             ->whereNotNull('end_date')
//             ->where('end_date', '<=', now())
//             ->get();

//         $this->info("Found {$maturedStakes->count()} matured stakes");

//         foreach ($maturedStakes as $stake) {
//             try {
//                 DB::beginTransaction();

//                 // Update stake status
//                 $stake->update(['status' => 'completed']);

//                 // Create unstake transaction with full amount + rewards
//                 $unstakeAmount = $stake->amount + $stake->total_reward;
//                 WalletTransaction::create([
//                     'user_id' => $stake->user_id,
//                     'type' => 'unstake',
//                     'amount' => $unstakeAmount,
//                     'status' => 'completed',
//                     'metadata' => [
//                         'stake_id' => $stake->id,
//                         'original_amount' => $stake->amount,
//                         'reward_amount' => $stake->total_reward,
//                         'maturity' => true,
//                     ],
//                 ]);

//                 DB::commit();
//                 $this->info("Processed matured stake #{$stake->id} - Amount: {$unstakeAmount} USDT");
//             } catch (\Exception $e) {
//                 DB::rollBack();
//                 $this->error("Failed to process matured stake #{$stake->id}: {$e->getMessage()}");
//             }
//         }

//         $this->info('Staking maturity check completed');
//     }
// } 