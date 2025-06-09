<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deposit') }}
        </h2>
    </x-slot>

    <div class="container">
              <div class="text-right mb-4">
					<a href="{{ route('wallet.index') }}" class="btn btn-primary btn-rounded"><i class="ti-arrow-left"></i> Back to Wallet</a>
			</div>
        <div class="row">
            <div class="col-md-12 card">
									<div class="card-header d-sm-flex d-block pb-0 border-0">
										<div>
											<h4 class="fs-20 text-black">Deposit Funds</h4>
											<p class="mb-0 fs-12">Always confirm wallet address before sending</p>
										</div>
                                    <div class="d-flex justify-content-center p-2"><img width="50px" src="{{asset('images/usdt.svg')}}"></div>
											
									</div>
									<div class="card-body">
                <div class=" p-6">
                    <div class="text-center mb-8 d-flex flex-column align-items-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Your Deposit Address</h3>
                        <div class="p-2 m-2 bg-white rounded" style="max-width: 230px; max-height:230px;">{!! $qrCode !!}</div>
                        <div class="flex items-center justify-center space-x-1">
                            
                            <p class="text-xs font-mono bg-gray-100 px-4 py-2 rounded mb-0">{{ $address }}</p>
                            <button onclick="copyToClipboard('{{ $address }}')" class="text-indigo-600 hover:text-indigo-900">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="max-w-2xl mx-auto">
                        <div class="card rounded-lg p-6 mb-8" style="border: dashed 2px grey">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Important Information</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Only send USDT (BEP-20) to this address
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Minimum deposit amount: 10 USDT
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Deposits are credited after 6 network confirmations
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Do not send any other cryptocurrencies to this address
                                </li>
                            </ul>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('wallet.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Back to Wallet
                            </a>
                        </div>
                                    <!-- Pending Deposits -->

                    </div>
                </div>
                  </div>
            </div>
</div>
        </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                toastr.success('Wallet Address copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
    @endpush
</x-app-layout>