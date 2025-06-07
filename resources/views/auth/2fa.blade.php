<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h4 class="text-center mb-4">Enter OTP From your Google Authentication App</h4>
    <form method="POST" action="{{ route('2fa') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Enter 2FA Code')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('email')" required autofocus autocomplete="otp" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
            <x-primary-button class="btn-block mt-3">
                {{ __('Verify') }}
            </x-primary-button>
    </form>
</x-guest-layout>
