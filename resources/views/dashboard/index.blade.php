<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

<div class="container-fluid">
				<div class="row">
					<div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
						<div class="widget-stat card">
							<div class="card-body p-4">
								<div class="media ai-icon">
									<span class="me-3 bgl-primary text-primary">
										<i class="ti-wallet text-success" style="font-size: 2rem"></i>
									</span>
									<div class="media-body">
										<p class="mb-1">Available Balance</p>
										<h4 class="mb-0">{{ number_format($stats['balance'], 2) }} USDT</h4>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body p-4">
								<div class="media ai-icon">
									<span class="me-3 bgl-warning text-warning">
										<i class="flaticon-381-layer-1" style="font-size: 2rem"></i>
									</span>
									<div class="media-body">
										<p class="mb-1">Staked Balance</p>
										<h4 class="mb-0">{{ number_format($stats['staked_balance'], 2) }} USDT</h4>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body  p-4">
								<div class="media ai-icon">
									<span class="me-3 bgl-danger text-danger">
										<svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
											<line x1="12" y1="1" x2="12" y2="23"></line>
											<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
										</svg>
									</span>
									<div class="media-body">
										<p class="mb-1">Total Earnings</p>
										<h4 class="mb-0">{{ number_format($stats['total_earnings'], 2) }} USDT</h4>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                        <div class="widget-stat card">
							<div class="card-body p-4">
								<div class="media ai-icon">
									<span class="me-3 bgl-secondary text-secondary">
										<i class="la la-users" style="font-size: 2rem"></i>
									</span>
									<div class="media-body">
										<p class="mb-1">Referral Earnings</p>
										<h4 class="mb-0">{{ number_format($stats['referral_earnings'], 2) }} USDT</h4>
									</div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Active Stakes -->
                <div class="overflow-hidden">
                    <div>
                        <h3 class="p-6 text-lg font-medium text-gray-900">Active Stakes</h3>
                        @if($activeStakes->isEmpty())
                            <p class="text-gray-500 text-center">No active stakes</p>
                        @else
                            <div class="space-y-4">
                                @foreach($activeStakes as $stake)
                                <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header d-block d-sm-flex border-0 pb-0">
                                        <h4 class="mb-0 text-black fs-20 d-flex justify-content-center align-items-center">
                                            <svg class="m-1" width="14" height="14" viewbox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect width="14" height="14" rx="4" fill="{{$stake->progress_color}}"></rect>
                                                        </svg>
                                            {{ $stake->stakingPlan->name }}</h4>
                                        
                                        <div class="d-flex mt-sm-0 mt-2 text-center">
                                            <a href="{{route('staking.index')}}" class="btn-sm btn-link text-primary underline">View Details</a>
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
                                                    </div>
                                                    <div class="col-sm-4  text-center">
                                                         <div class="col-12 mb-sm-0 mb-4">
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
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

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
                             @if($recentTransactions->isEmpty())
                                <p class="text-gray-500 text-center">No recent transactions</p>
                            @else
									<div class="table-responsive">
										<table class="table shadow-hover short-one card-table border-no">
											<tbody>
                                               
                                                 @foreach($recentTransactions as $transaction)
                                                     @php
                                                        $addition = ['deposit', 'reward', 'unstake','referral'];
                                                        $subtraction = ['withdrawal', 'stake', 'fee'];
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


    @push('scripts')
    <script>

    </script>
    @endpush
</x-app-layout> 