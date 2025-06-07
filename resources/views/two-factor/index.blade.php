<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Two Factor Authentication') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <x-profile-settings title="Advanced" />
    <div>
            <div class="card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="max-w-2xl mx-auto">
                        @if(auth()->user()->two_factor_enabled)
                            <div class="mb-8">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication is Enabled</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Your account is protected with two-factor authentication.
                                        </p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Enabled
                                    </span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('two-factor.disable') }}" class="space-y-6">
                                @csrf
                                <div>
                                    <x-input-label for="code" :value="__('Verification Code')" />
                                    <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" required autofocus />
                                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                        Back to Profile
                                    </a>

                                    <x-danger-button>
                                        {{ __('Disable Two-Factor Authentication') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        @else
                            <div class="mb-8">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication is Disabled</h3>
                                        <p class="mt-1 text-sm text-gray-600">
                                            Add an extra layer of security to your account by enabling two-factor authentication.
                                        </p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Disabled
                                    </span>
                                </div>
                            </div>

                            <div class="card rounded-lg p-6 mb-8" style="border: 2px dashed grey">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">How it works</h4>
                                <ol class="space-y-4 text-sm text-gray-600">
                                    <li class="flex items-start">
                                        <span class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-medium">1</span>
                                        <span class="ml-3">Download and install an authenticator app like Google Authenticator or Authy on your phone.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-medium">2</span>
                                        <span class="ml-3">Scan the QR code or enter the secret key provided when you enable 2FA.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="flex-shrink-0 h-6 w-6 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600 font-medium">3</span>
                                        <span class="ml-3">Enter the 6-digit code from your authenticator app to verify and enable 2FA.</span>
                                    </li>
                                </ol>
                            </div>

                            <div class="flex items-center justify-between">
                                <a href="{{ route('profile.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    Back to Profile
                                </a>

                                <form method="POST" action="{{ route('two-factor.enable') }}">
                                    @csrf
                                    <x-primary-button>
                                        {{ __('Enable Two-Factor Authentication') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

    </div>
           </div>
         </div>
    </div>
</x-app-layout> 