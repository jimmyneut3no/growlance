<!--**********************************
            Header start
        ***********************************-->
<ul class="navbar-nav header-right">
							<li class="nav-item">
								  <div class="row">
									  <div id="themeToggle" class="theme-toggle" role="button">
											<i id="themeIcon" class="fas fa-sun"></i>
										</div>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <i class="flaticon-381-ring"></i>
                                    <div class="pulse-css"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3" style="height:380px;">
										<ul class="timeline">
										@forelse ($notificationData as $transaction)
										<li>
												<div class="timeline-panel">
														@php
															$ttype = Str::substr(ucfirst($transaction->type), 0, 1);
														@endphp
													<div class="media me-2 {{ ($ttype == 'W' || $ttype == 'S')?'media-danger':'media-success'; }}">
														{{Str::substr(ucfirst($transaction->type), 0, 1)}}
													</div>
													<div class="media-body">
														<h6 class="mb-1">{{ ucfirst($transaction->type) }} — {{ number_format($transaction->amount, 2) }}USDT </h6>
														<small class="d-block">{{ $transaction->created_at->diffForHumans() }}</small>
													</div>
												</div>
											</li>
										@empty
											<li>No recent transactions</li>
										@endforelse
											

										</ul>
									</div>
                                    <a class="all-notification" href="{{route('wallet.transactions')}}">See all transactions <i class="ti-arrow-right"></i></a>
                                </div>
                            </li>
    <li class="nav-item dropdown header-profile">
        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
            <div style="width:50px">{!! Auth::user()->getAvatar(); !!}</div>
            <div class="header-info">
                <span>{{ Auth::user()->name }}</span>
                <small>@ {{Auth::user()->username }}</small>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            
            <a href="{{route('profile.index')}}" class="dropdown-item ai-icon">
                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18"
                    viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="ms-2">Profile </span>
            </a>
           
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" class="dropdown-item ai-icon" onclick="event.preventDefault(); this.closest('form').submit();">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18"
                                    viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ms-2">Logout </span>
                            </a>
            </form>
        </div>
    </li>
</ul>

<!--**********************************
            Header end ti-comment-alt
        ***********************************-->
