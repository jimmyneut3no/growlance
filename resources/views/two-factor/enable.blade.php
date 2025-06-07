<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Enable Two Factor Authentication') }}
        </h2>
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <x-profile-settings title="Enable 2FA" />
    <div>
            <div class="card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="max-w-2xl mx-auto">
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Set up your authenticator app</h3>
                            <p class="text-sm text-gray-600 mb-6">
                                Scan the QR code below using your authenticator app. If you can't scan the QR code, you can manually enter the secret key.
                            </p>

                            <div class="flex flex-col items-center space-y-6">
                                <!-- QR Code -->
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-48 h-48">
                                </div>

                                <!-- Secret Key -->
                                <div class="w-full max-w-md">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Secret Key</label>
                                    <div class="flex items-center space-x-2">
                                        <input type="text" value="{{ $secretKey }}" readonly class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                                        <button type="button" onclick="copyToClipboard('{{ $secretKey }}, this')" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('two-factor.confirm') }}" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="code" :value="__('Verification Code')" />
                                <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" required autofocus />
                                <p class="mt-1 text-sm text-gray-500">Enter the 6-digit code from your authenticator app.</p>
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between">
                                <a href="{{ route('two-factor.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                    Back
                                </a>

                                <x-primary-button>
                                    {{ __('Verify and Enable') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text, element) {
            navigator.clipboard.writeText(text).then(() => {
                // Show a temporary success message
                const button = element;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                setTimeout(() => {
                    button.textContent = originalText;
                }, 2000);
            });
        }
    </script>
    @endpush
</x-app-layout> 