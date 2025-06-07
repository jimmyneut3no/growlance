@props(['title' => "Settings"])

@php
// $classes = ($active ?? false) ? 'mm-active' : '';
@endphp

				<div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="javascript:void(0);">Profile</a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0);">{{$title}}</a></li>
					</ol>
                </div>
				<div class="card profile-overview profile-overview-wide" style="height: auto">
					<div class="card-body d-flex">
						<div class="clearfix">
							<div class="d-inline-block position-relative me-sm-4 me-3 mb-3 mb-lg-0">
								<div class="rounded profile-avatar" style="width: 80px">{!! Auth::user()->getAvatar(); !!}</div>
								<span class="fa fa-circle border border-3 border-white text-success position-absolute bottom-0 end-0 rounded-circle"></span>
							</div>
						</div>
						<div class="clearfix d-xl-flex flex-grow-1">
							<div class="clearfix pe-md-5">
								<h3 class="fw-semibold mb-1">{{ Auth::user()->name }} <img style="display:inline-flex" src="{{asset('images/blue-tick.png')}}" alt="Blue Tick"></h3>
								<ul class="d-flex flex-wrap fs-6 align-items-center">
									<li class="me-3 d-inline-flex align-items-center"><i class="las la-user me-1 fs-18"></i>{{ Auth::user()->username }}</li>
									<li class="me-3 d-inline-flex align-items-center"><i class="las la-envelope me-1 fs-18"></i>{{ Auth::user()->email }}</li>
								</ul>
								<div class="d-md-flex d-none flex-wrap">
									<div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
										<div class="avatar avatar-md bg-primary-light text-primary rounded d-flex align-items-center justify-content-center">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M12 1V23" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="clearfix ms-2">
											<h3 class="mb-0 fw-semibold lh-1">{{number_format(Auth::user()->getBalance(),2)}} USDT</h3>
											<span class="fs-14">Total Balance</span>
										</div>
									</div>
									{{-- <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
										<div class="avatar avatar-md bg-primary-light text-primary rounded d-flex align-items-center justify-content-center">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="clearfix ms-2">
											<h3 class="mb-0 fw-semibold lh-1">125</h3>
											<span class="fs-14">Total Referrals</span>
										</div>
									</div> --}}
									{{-- <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
										<div class="avatar avatar-md bg-primary-light text-primary rounded d-flex align-items-center justify-content-center">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
												<path d="M16 21V5C16 4.46957 15.7893 3.96086 15.4142 3.58579C15.0391 3.21071 14.5304 3 14 3H10C9.46957 3 8.96086 3.21071 8.58579 3.58579C8.21071 3.96086 8 4.46957 8 5V21" stroke="var(--primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
										</div>
										<div class="clearfix ms-2">
											<h3 class="mb-0 fw-semibold lh-1">25</h3>
											<span class="fs-14">Total Stakes</span>
										</div>
									</div> --}}
								</div>
							</div>
							<div class="clearfix mt-3 mt-xl-0 ms-auto d-flex flex-column col-xl-3">
								<form method="POST" action="{{ route('logout') }}">
									@csrf
									<div class="clearfix mb-3 text-xl-end">
										<a href="#" class="btn btn-light mb-2" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
										{{-- <a href="javascript:void(0);" class="btn btn-primary ms-2 mb-2">Offer a Deal</a> --}}
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="card-footer py-0 d-flex flex-wrap justify-content-between align-items-center">
						<ul class="nav nav-underline nav-underline-primary nav-underline-text-dark nav-underline-gap-x-0" id="tabMyProfileBottom" role="tablist">
							<li class="nav-item ms-1" role="presentation">
								<a href="{{route('profile.index')}}"  class="nav-link py-3 border-3 text-dark {{(request()->routeIs('profile.index'))?'active':'';}}">Overview</a>
							</li>
							<li class="nav-item ms-1" role="presentation">
								<a href="{{route('profile.password')}}" class="nav-link py-3 border-3 text-dark {{(request()->routeIs('profile.password'))?'active':'';}}">Change Password</a>
							</li>
							<li class="nav-item ms-1" role="presentation">
								<a href="{{route('two-factor.index')}}" class="nav-link py-3 border-3 text-dark {{(request()->routeIs('two-factor.*'))?'active':'';}}">2FA authentication</a> 
							</li>
							{{-- <li class="nav-item ms-1" role="presentation">
								<a href="{{route('profile.index')}}" class="nav-link py-3 border-3 text-dark">KYC</a>
							</li> --}}
							<li class="nav-item ms-1" role="presentation">
								<a href="{{route('profile.advanced')}}" class="nav-link py-3 border-3 text-dark {{(request()->routeIs('profile.advanced'))?'active':'';}}">Advanced</a>
							</li>
						</ul>
					</div>
				</div>

