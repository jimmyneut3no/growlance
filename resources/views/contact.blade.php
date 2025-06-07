		<x-main-layout>
			<!-- ***** Breadcrumb Area Start ***** -->
		<section class="breadcrumb-area overlay-dark d-flex align-items-center">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Breamcrumb Content -->
						<div class="breadcrumb-content text-center">
							<h2>Contact Us</h2>
							<ol class="breadcrumb d-flex justify-content-center">
								<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
								<li class="breadcrumb-item active">Contact</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Breadcrumb Area End ***** -->

		<!-- ***** Contact Area Start ***** -->
		<section class="apply-area contact">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-md-7">
						<div class="apply-form card no-hover">
							<!-- Intro -->
							<div class="intro d-flex justify-content-between align-items-end mb-4">
								<div class="intro-content">
									<span class="intro-text">Contact Us</span>
									<h3 class="mt-3 mb-0">Get In Touch!</h3>
								</div>
							</div>
							<form id="contact-form" method="POST" action="#">
								<div class="form-group">
									<label for="first-name">First name</label>
									<input type="text" id="first-name" name="first-name" placeholder="John" required="required">
								</div>
								<div class="form-group">
									<label for="last-name">Last name</label>
									<input type="text" id="last-name" name="last-name" placeholder="Deo" required="required">
								</div>
								<div class="form-group">
									<label for="email">Email Address</label>
									<input type="email" id="email" name="email" placeholder="name@yourmail.com" required="required">
									<small class="form-text mt-2">Enter your email address</small>
								</div>
								<div class="form-group">
									<label for="phone">Phone (Optional)</label>
									<input type="text" id="phone" name="phone" placeholder="E.g. +220 541 0014">
								</div>
								<div class="form-group">
									<label for="description">Message</label>
									<textarea id="description" name="message" placeholder="Message" cols="30" rows="3" required="required"></textarea>
									<small class="form-text mt-2">Briefly describe what you need</small>
								</div>
								<button type="submit" class="btn btn-bordered active">Submit Message <i class="icon-login ms-2"></i></button>
							</form>
							<p class="form-message"></p>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="contact-items mt-4 mt-md-0">
							<!-- Single Card -->
							<div class="card no-hover staking-card">
								<div class="media">
									<i class="icon text-effect icon-location-pin m-0"></i>
									<div class="media-body ms-4">
										<h4 class="m-0">Growlance Inc.</h4>
										<p class="my-3">2709 Euclid Avenue, Irvine, California</p>
									</div>
								</div>
							</div>
							<!-- Single Card -->
							<div class="card no-hover staking-card my-4">
								<div class="media">
									<i class="icon text-effect icon-call-out m-0"></i>
									<div class="media-body ms-4">
										<h4 class="m-0">Call Us</h4>
										<span class="d-inline-block mt-3 mb-1">+805-298-8971</span>
										<span class="d-inline-block">+626-773-0240</span>
									</div>
								</div>
							</div>
							<!-- Single Card -->
							<div class="card no-hover staking-card">
								<div class="media">
									<i class="icon text-effect icon-envelope-open m-0"></i>
									<div class="media-body ms-4">
										<h4 class="m-0">Reach Us</h4>
										<span class="d-inline-block mt-3 mb-1"><a href="mailto:info@growlance.io">info@growlance.io</a></span>
										<span class="d-inline-block"><a href="mailto:support@growlance.io">support@growlance.io</a></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- ***** Contact Area End ***** -->
	</x-main-layout>