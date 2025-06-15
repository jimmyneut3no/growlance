<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staking') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3 class="text-lg font-medium text-primary mb-4">Active Stakes</h3>
            </div>
            <div class="col-6 text-right mb-4">
                        {{-- <button id="processRewardsBtn" class="btn btn-primary">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Staking Pool
                        </button> --}}
            </div>
            </div>
            @if($activeStakes->isEmpty())
                <div class="col-12">
                    <p class="text-gray-500 text-center">No active stakes</p>
                </div>
            <div class="col-12">
                <h3 class="text-lg font-medium text-primary mb-4">Choose Staking Plan</h3>
            </div>
                 <!-- Staking Plans -->
                @foreach($stakingPlans as $plan)
                <div class="col-md-6">				
                <div class="card h-auto">
									<div class="card-header d-sm-flex d-block pb-0 border-0">
										<div>
											<h4 class="fs-20 text-black">{{ $plan->name }}</h4>
											<p class="mb-0 fs-12">{{ $plan->type }} Plan</p>
										</div>
										<div class="text-right">
                                            <p class="text-2xl font-bold text-indigo-600">{{ $plan->apy }}%</p>
                                            <p class="text-sm text-gray-500">Reward</p>
                                        </div>
									</div>
									<div class="card-body">
                                         <div class="space-y-2 mb-6">
										<div class="d-flex mb-3 justify-content-between align-items-center">
                                                <span class="text-black">Duration</span>
                                                <span class="">{{ $plan->lock_period }} days</span>
                                            </div>
										<div class="d-flex mb-3 justify-content-between align-items-center">
                                                <span class="text-black">Min Amount</span>
                                                <span class="">{{ number_format($plan->min_stake, 2) }} USDT</span>
                                            </div>
										<div class="d-flex mb-3 justify-content-between align-items-center">
                                                <span class="text-black">Max Amount</span>
                                                <span class="">{{ number_format($plan->max_stake, 2) }} USDT</span>
                                            </div>
                                        </div>
                                        <form action="{{ route('staking.stake', $plan) }}" method="POST">
                                            @csrf
                                            <div class="amount-bx">
                                                <label>Amount(USDT)</label>
                                                <input id="amount" name="amount" type="number" class="form-control" placeholder="0.00"  step="0.01">
                                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                                            </div>
                                            <button class="btn btn-primary w-100 d-block btn-lg text-uppercase">{{ __('Stake Now') }}</button>
                                        </form>
									</div>
								</div></div>
                @endforeach
             @else
            @foreach($activeStakes as $stake)
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-block d-sm-flex border-0 pb-0">
                                        <h4 class="mb-0 text-black fs-20 d-flex justify-content-center align-items-center">
                                            <svg class="m-1" width="14" height="14" viewbox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect width="14" height="14" rx="4" fill="{{$stake->progress_color}}"></rect>
                                                        </svg>
                                            {{ $stake->stakingPlan->name }}</h4>
                                        
                                        <div class="d-flex mt-sm-0 mt-2">
                                            {{-- <a href="javascript:void(0);" class="btn-sm btn-link text-primary underline">REFRESH</a> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row align-items-end">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-sm-4  text-center">
                                                        <div class="mb-4">
                                                            <p class="small">Daily Reward</p>
                                                            <h4 class="text-black">{{ number_format($stake->daily_reward, 2) }} USDT</h4>
                                                        </div>
                                                        <div class="mb-4">
                                                            <p class="small">Total Earn</p>
                                                            <h4 class="text-black">{{ number_format($stake->total_reward, 2) }} USDT</h4>
                                                        </div>
                                                        @if($stake->end_date)
                                                            <div class="mb-4">
                                                                <p class="small">Maturity Date</p>
                                                                 <h4 class="text-black">{{ $stake->end_date->format('M d, Y') }}</h4>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-4  text-center">
                                                        <div class="mb-4">
                                                            <p class="small">Amount Staked</p>
                                                            <h4 class="text-black">{{ number_format($stake->amount, 2) }} USDT</h4>
                                                        </div>
                                                        <div class="mb-4">
                                                            <p class="small">Reward</p>
                                                            <h4 class="text-black">{{ $stake->apy }}%</h4>
                                                        </div>
                                                        <div class="mb-4">
                                                            <p class="small">Stake type</p>
                                                            <h4 class="text-black">{{ $stake->stakingPlan->type }}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4  text-center">
                                                        <div class="mb-4">
                                                            <p class="small">Duration</p>
                                                            <h4 class="text-black">{{ $stake->stakingPlan->lock_period }} Days</h4>
                                                        </div>
                                                         <div class="col-12 mb-sm-0 mb-4 text-center">
                                                        <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                            <span class="donut1" data-peity='{ "fill": ["{{$stake->progress_color}}", "rgba(240, 240, 240)"],   "innerRadius": 40, "radius": 10}'>{{$stake->ratio}}/8</span>
                                                            <small class="text-black">{{$stake->progress_percent}}%</small>
                                                        </div>
                                                        <h5 class="text-black text-xs">Stake Progress</h5>
                                                        {{-- <span>$10,000</span> --}}
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    
                                    @if($stake->canUnstake())
                                        <form action="{{ route('staking.unstake', $stake) }}" method="POST" class="mt-4">
                                            @csrf
                                            <x-primary-button class="w-full justify-center">
                                                {{ __('Unstake') }}
                                            </x-primary-button>
                                        </form>
                                    @endif
            @endforeach
            @endif
        </div>
        </div>
@push('scripts')
<script>
document.getElementById('processRewardsBtn').addEventListener('click', async function() {
    const button = this;
    const originalText = button.innerHTML;
    
    try {
        // Disable button and show loading state
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        
        // Make API call with longer timeout
        const response = await fetch('{{ route("stakes.process-rewards") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            timeout: 30000 // 30 seconds timeout
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Show success message with results
            let message = 'Rewards processed successfully:\n\n';
            data.results.forEach(result => {
                message += `Stake #${result.stake_id}: ${result.message}\n`;
                if (result.total_reward) {
                    message += `Total reward: ${result.total_reward}\n`;
                }
                message += '\n';
            });
            
            // Show success toast with results
            toastr.success(message, 'Success', {
                timeOut: 10000, // Show for 10 seconds
                extendedTimeOut: 5000,
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right"
            });
            
            // Reload the page to show updated stakes
            setTimeout(() => {
                window.location.reload();
            }, 2000); // Wait 2 seconds before reloading to show the toast
        } else {
            throw new Error(data.message || 'Failed to process rewards');
        }
    } catch (error) {
        console.error('Error:', error);
        toastr.error(error.message || 'Failed to process rewards. Please try again.', 'Error', {
            timeOut: 5000,
            extendedTimeOut: 2000,
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right"
        });
    } finally {
        // Restore button state
        button.disabled = false;
        button.innerHTML = originalText;
    }
});
</script>
@endpush 

</x-app-layout> 