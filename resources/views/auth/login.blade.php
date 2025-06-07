<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h4 class="text-center mb-4">Sign in your account</h4>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 form-group">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="form-row d-flex justify-content-between mt-4 mb-2">
            <div class="form-group">
                                                <div class="form-check custom-checkbox ms-1">
													<input type="checkbox" class="form-check-input"  name="remember" id="remember_me">
													<label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
												</div>
                                            </div>
@if (Route::has('password.request'))
<div class="form-group">
       <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
</div>
@endif 
</div>
            <x-primary-button class="btn-block">
                {{ __('Log in') }}
            </x-primary-button>                                    

    </form>
    <div class="new-account mt-3">
        <p>Don't have an account? <a class="text-primary" href="{{route('register')}}">Sign up</a></p>
    </div>
</x-guest-layout>
