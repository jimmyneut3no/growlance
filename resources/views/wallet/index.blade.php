<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>

			<div class="container">
				<div class="text-right mb-4">
					<a href="{{ route('wallet.deposit') }}" class="btn btn-primary btn-rounded mr-2">+ Add funds</a>
					<a href="{{ route('wallet.withdraw') }}" class="btn btn-primary btn-rounded"><i class="ti-arrow-right"></i> Withdraw funds</a>
				</div>
				<div class="cards-slider mb-4 row">
					<div class="col-md-6 items mb-2">
						<div class="wallet-card bg-success" style="background-image:url('images/pattern/pattern2.png');width:100%;">
							<div class="head">
								<p class="fs-14 text-white mb-0 op6 font-w100">Available Balance</p>
								<span>{{ number_format($balance, 2) }} USDT</span>
							</div>
							<div class="wallet-footer">
								<img src="{{asset('images/card-logo.png')}}" alt="">
							</div>
						</div>
					</div>
					<div class="col-md-6 items">
						<div class="wallet-card bg-secondary" style="background-image:url('images/pattern/pattern1.png');width:100%;">
							<div class="head">
								<p class="fs-14 text-white mb-0 op6 font-w100">Total Earnings</p>
								<span>{{number_format(Auth::user()->getTotalEarnings(),2)}} USDT</span>
							</div>
							<div class="wallet-footer">
								<img src="{{asset('images/card-logo2.png')}}" alt="">
							</div>
						</div>
					</div>
					
                </div>

        <div>
            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        @if($pendingDeposits->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pending Deposits</h3>
                        <div class="space-y-4">
                            @foreach($pendingDeposits as $deposit)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">Deposit</h4>
                                            <p class="text-sm text-gray-500">{{ $deposit->created_at->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-900">{{ number_format($deposit->amount, 2) }} USDT</p>
                                            <p class="text-sm text-yellow-500">Pending</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            <!-- Recent Transactions -->
                    	<div class="card">
							<div class="card-header pb-2 d-block d-sm-flex flex-wrap border-0">
								<div class="mb-3">
									<h4 class="fs-20 text-black">Recent Transactions</h4>
								</div>
								<div class="card-tabs mb-3">
									<a href="{{route('wallet.transactions')}}">View All Transaction</a>
								</div>
							</div>
							<div class="card-body p-0">
                                @php
                                    $recentTransactions = Auth::user()->walletTransactions()->latest()->take(5)->get();
                                @endphp
                             @if($recentTransactions->isEmpty())
                                <p class="text-gray-500">No recent transactions</p>
                            @else
									<div class="table-responsive">
										<table class="table shadow-hover short-one card-table border-no">
											<tbody>
                                               
                                                 @foreach($recentTransactions as $transaction)
                                                     @php
                                                        $addition = ['deposit', 'reward', 'unstake','referral'];
                                                        $subtraction = ['withdrawal', 'stake','fee'];
                                                        $type = strtolower($transaction->type); // normalize for safety
                                                        $isAddition = in_array($type, $addition);
                                                        $isSubtraction = in_array($type, $subtraction);
                                                        $amountFormatted = number_format($transaction->amount, 2);
                                                        $sign = $isAddition ? '+' : ($isSubtraction ? '-' : '');
                                                        $color = $isAddition ? 'text-success' : ($isSubtraction ? 'text-danger' : 'text-muted');
                                                    @endphp
                                    <tr>
													<td>
														<span class="activity-icon">
                                                            @if ($sign == '-')
                                                              <svg width="15" height="27" viewbox="0 0 15 27" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M5.9375 6.232L5.9375 24.875C5.9375 25.6689 6.58107 26.3125 7.375 26.3125C8.16892 26.3125 8.8125 25.6689 8.8125 24.875L8.8125 6.23202L11.2311 8.66232L11.2311 8.66234C11.7911 9.22504 12.7013 9.2272 13.264 8.66718C13.8269 8.10702 13.8288 7.19681 13.2689 6.63421L12.9145 6.98691L13.2689 6.63421L8.3939 1.73558L8.38872 1.73037L8.38704 1.72878C7.82626 1.17281 6.92186 1.17469 6.36301 1.72877L6.36136 1.73033L6.35609 1.73563L1.48109 6.63426L1.48108 6.63426C0.921124 7.19695 0.9232 8.10709 1.48597 8.6672C2.04868 9.22725 2.95884 9.22509 3.51889 8.66239L3.51891 8.66236L5.9375 6.232Z" fill="rgb(255, 104, 38)" stroke="rgb(255, 104, 38)"></path>
															</svg>
                                                            @else
                                                            <svg width="15" height="27" viewbox="0 0 15 27" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path d="M8.81299 21.393L8.81299 2.74998C8.81299 1.95606 8.16942 1.31248 7.37549 1.31248C6.58157 1.31248 5.93799 1.95606 5.93799 2.74998L5.93799 21.393L3.5194 18.9627L3.51938 18.9627C2.95934 18.4 2.0492 18.3978 1.48649 18.9578C0.923597 19.518 0.921712 20.4282 1.48158 20.9908L1.83599 20.6381L1.48158 20.9908L6.35659 25.8894L6.36177 25.8946L6.36345 25.8962C6.92422 26.4522 7.82863 26.4503 8.38748 25.8962L8.38912 25.8947L8.3944 25.8894L13.2694 20.9907L13.2694 20.9907C13.8294 20.428 13.8273 19.5179 13.2645 18.9578C12.7018 18.3977 11.7917 18.3999 11.2316 18.9626L11.2316 18.9626L8.81299 21.393Z" fill="#61C277" stroke="#61C277"></path>
															</svg>
                                                            @endif
															
														</span>
													</td>
													<td>
														<span class="font-w600 text-black">{{ ucfirst($transaction->type) }}</span><br>
                                                        <small class="text-black">{{ $transaction->created_at->format('M d, H:i') }}</small>
													</td>
													<td>
														<span class="font-w600 text-black">{{ $sign.number_format($transaction->amount, 2) }} USDT</span><br>
													<small class="{{ $transaction->status === 'completed' ? 'text-green' : 'text-orange' }}"> {{ ucfirst($transaction->status) }}</small>
                                                    </td>
												</tr>
                                @endforeach
								
											</tbody>
										</table>
									</div>
                                    @endif
                            </div>

                </div>



            </div>
        </div>
    </div>
</x-app-layout> 