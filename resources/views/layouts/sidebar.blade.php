        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <!-- Navigation Links -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" :icon="'flaticon-381-speedometer'">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                     <x-nav-link :href="route('wallet.index')" :active="request()->routeIs('wallet.*')" :icon="'la la-wallet'" :isDropdown="true">
                        {{ __('Wallet') }}

                        {{-- Sub Navigation --}}
                        <x-slot name="subnav">
                            <ul aria-expanded="false">
                                <x-subnav :href="route('wallet.index')">{{ __('Main Wallet') }}</x-subnav>
                                <x-subnav :href="route('wallet.deposit')">{{ __('Deposit') }}</x-subnav>
                                <x-subnav :href="route('wallet.withdraw')">{{ __('Withdraw') }}</x-subnav>
                                <x-subnav :href="route('wallet.transactions')">{{ __('All Transactions') }}</x-subnav>
                            </ul>
                        </x-slot>
                    </x-nav-link>
                    <x-nav-link :href="route('staking.index')" :active="request()->routeIs('staking.*')" :icon="'flaticon-381-layer-1'" :isDropdown="true">
                        {{ __('Staking') }}

                        {{-- Sub Navigation --}}
                        <x-slot name="subnav">
                            <ul aria-expanded="false">
                                <x-subnav :href="route('staking.index')">{{ __('Active Plan') }}</x-subnav>
                                <x-subnav :href="route('staking.plans')">{{ __('Staking Plans') }}</x-subnav>
                                <x-subnav :href="route('staking.history')">{{ __('Staking History') }}</x-subnav>
                                
                            </ul>
                        </x-slot>
                    </x-nav-link>
                    <x-nav-link :href="route('referral.index')" :active="request()->routeIs('referral.index')" :icon="'la la-users'">
                        {{ __('Referral') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.index')" :icon="'la la-users-cog'">
                        {{ __('Profile & Settings') }}
                    </x-nav-link>
                    <x-nav-link :href="route('support.contact')" :active="request()->routeIs('support.contact')" :icon="'flaticon-381-networking'">
                        {{ __('Support') }}
                    </x-nav-link>
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" :icon="'flaticon-381-tab'">
                        {{ __('Visit Official Website') }}
                    </x-nav-link>
                </ul>
            
				<div class="book-box">
					<img src="{{asset('images/book.png')}}" alt="">
					<a href="{{route('home')}}#how-it-works">Learn How it Works ></a>
				</div>
				<div class="copyright">
					<p><strong>Growlance</strong> © 2025 All Rights Reserved</p>
				</div>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->