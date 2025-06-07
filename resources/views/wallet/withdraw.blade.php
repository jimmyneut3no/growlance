<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Withdraw') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="text-right mb-4">
					<a href="{{ route('wallet.index') }}" class="btn btn-primary btn-rounded"><i class="ti-arrow-left"></i> Back to Wallet</a>
			</div>
    <div class="row">
        <div class="col-md-6">
        <div class="card">
									<div class="card-header d-sm-flex d-block pb-0 border-0">
										<div>
											<h4 class="fs-20 text-black">Withdrawal</h4>
										</div>
									</div>
									<div class="card-body">
                                    <div class="wallet-card bg-success" style="background-image:url({{asset('images/pattern/pattern2.png')}});width:100%;">
                                        <div class="head">
                                            <p class="fs-14 text-white mb-0 op6 font-w100">Available Balance</p>
                                            <span>{{ number_format($balance, 2) }} USDT</span>
                                        </div>
                                        <div class="wallet-footer">
                                            <img src="{{asset('images/card-logo.png')}}" alt="">
                                        </div>
                                    </div>
                             
                                    <div class="card h-auto shadow-none rounded-lg p-6 mb-8 mt-5">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Withdrawal Information</h4>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Minimum withdrawal amount: 10 USDT
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Withdrawal fee: 2%
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Processing time: 5-30 minutes
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Make sure to enter the correct BEP-20 address
                                    </li>
                                </ul>
                            </div>
									</div>
								</div>
								</div>
                                <div class="col-md-6">
                                <div class="card">
									<div class="card-header d-sm-flex d-block pb-0 border-0">
										<div>
											<h4 class="fs-20 text-black">Withdraw Funds</h4>
											<p class="mb-0 fs-12">Only Available funds can be withdrawn</p>
										</div>
										<div class="d-flex justify-content-center p-2"><img width="50px" src="{{asset('images/usdt.svg')}}"></div>
									</div>
									<div class="card-body">
										<div class="basic-form">

<form action="{{ route('wallet.withdraw') }}" method="POST" class="form-wrapper">
    @csrf

    <!-- Amount -->
    <div class="form-group">
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text">Amount (USD)</span>
            </div>
            <input id="amount" type="number" step="0.01" class="form-control" placeholder="0.00" oninput="calculateFeeAndTotal()">
        </div>
    </div>

    <!-- Address -->
    <div class="form-group">
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text">Address</span>
            </div>
            <input type="text" id="address" name="address" class="form-control" placeholder="0x.....">
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>
    </div>

    <!-- Fee (2%) -->
    <div class="form-group">
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text">Fee (2%)</span>
            </div>
            <input type="number" id="fee" class="form-control" placeholder="0.00" readonly>
        </div>
    </div>

    <!-- Total Amount -->
    <div class="form-group">
        <div class="input-group input-group-lg">
            <div class="input-group-prepend">
                <span class="input-group-text">Total Amount</span>
            </div>
            <input type="number" name="amount" id="total" class="form-control" placeholder="0.00" readonly>
            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
        </div>
    </div>

    <!-- Confirm Checkbox -->
    <div class="d-flex mt-3">
        <div class="form-check custom-checkbox me-3 mt-1">
            <input type="checkbox" class="form-check-input" id="customCheckBox1" required>
            <label class="form-check-label" for="customCheckBox1"></label>
        </div>
        <label class="mb-0">
            I confirm that the wallet address provided is correct, a USDT (BEP20) address, and active for withdrawal.
        </label>
    </div>

    <!-- Submit Button -->
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-6">
            <button type="submit" class="btn d-block btn-lg btn-warning">
                {{ __('Withdraw') }}
                <i class="ti-arrow-right"></i>
            </button>
        </div>
    </div>
</form>
<script>
    function calculateFeeAndTotal() {
        const amountInput = document.getElementById('amount');
        const feeInput = document.getElementById('fee');
        const totalInput = document.getElementById('total');

        const amount = parseFloat(amountInput.value);
        if (!isNaN(amount) && amount > 0) {
            const fee = (amount * 0.02).toFixed(2);
            const total = (amount - parseFloat(fee)).toFixed(2);
            feeInput.value = fee;
            totalInput.value = total;
        } else {
            feeInput.value = '';
            totalInput.value = '';
        }
    }
</script>

										</div>
									</div>
								</div>	        
								</div>	        
								</div>	        

    </div>
</x-app-layout> 