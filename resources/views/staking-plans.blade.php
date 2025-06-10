<x-main-layout>
			<!-- ***** Breadcrumb Area Start ***** -->
		<section class="breadcrumb-area overlay-dark d-flex align-items-center">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Breamcrumb Content -->
						<div class="breadcrumb-content text-center">
							<h2>Staking Plan</h2>
							<ol class="breadcrumb d-flex justify-content-center">
								<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
								<li class="breadcrumb-item"><a href="{{route('staking-plans')}}">Stake</a></li>
								<li class="breadcrumb-item active">Staking Plan</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Breadcrumb Area End ***** -->

		<!-- ***** Staking Plan Area Start ***** -->
		<section class="tier-system-area">
			<div class="container">
				<div class="row items">
					@foreach ($stakingPlans as $plan)
					<div class="col-12 col-md-6 col-lg-4 item">
						<!-- Single Tier Card -->
						<div class="card no-hover tier-card text-center">
							<h3 class="title mb-0">Tier {{$loop->iteration }}</h3>
							<span class="category mt-2">{{$plan->name }}</span>
							<div class="card-body">
								<ul class="list-unstyled">
									<li>
										<span>Staking Requirement</span>
										<span>{{number_format($plan->min_stake).' - '.number_format($plan->max_stake) }} USDT</span>
									</li>
									<li>
										<span>Reward</span>
										<span>[{{$plan->apy;}}% - daily]</span>
									</li>
									<li>
										<span>Currency</span>
										<span>USDT (BEP20)</span>
									</li>
									<li>
										<span>Locked for</span>
										<span>{{$plan->lock_period; }} Days</span>
									</li>
									<li>
										<span>Stake Type</span>
										<span>{{$plan->type }}</span>
									</li>
								</ul>
									<a class="btn btn-bordered active d-inline-block mt-5" href="{{route('register')}}"><i class="icon-rocket me-2"></i> Choose Plan</a>
							</div>
							<!-- Tier Type -->
							<div class="tier-type">
								<span>T{{$loop->iteration }}</span>
							</div>
						</div>
					</div>
@endforeach
				</div>
			</div>
		</section>
		<!-- ***** Staking Plan Area End ***** -->
		<!-- ***** CTA Area Start ***** -->
		<section class="cta-area p-0">
			<div class="container">
				<div class="row">
					<div class="col-12 card">
						<div class="row align-items-center justify-content-center">
							<div class="col-12 col-md-5 text-center">
								<img src="assets/img/content/cta_thumb.png" alt="">
							</div>
							<div class="col-12 col-md-6 mt-4 mt-md-0">
								<h2 class="m-0">Start Earning Up to 5% Reward on Your USDT!</h2>
								<p>Join 50,000+ investors growing their stablecoins with our secure, high-yield staking platform.</p>
								<a class="btn btn-bordered active d-inline-block" href="{{route('register')}}"><i class="icon-rocket me-2"></i> Stake Now</a>
							</div>
						</div>
						<a class="cta-link" href="{{route('register')}}"></a>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** CTA Area End ***** -->
	</x-main-layout>