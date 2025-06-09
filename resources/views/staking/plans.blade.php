<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staking Plans') }}
        </h2>
    </x-slot>

    <div class="container">
		 <div class="row">
            <div class="col-12">
                <h3 class="text-lg font-medium text-primary mb-4">Staking Plans</h3>
            </div></div>
            <!-- Staking Plans -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
                @foreach($stakingPlans as $plan)
                				<div class="card">
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
								</div>
                @endforeach
            </div>
        </div>
</x-app-layout> 