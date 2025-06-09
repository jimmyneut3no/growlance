<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Credentials') }}
            </h2>
            <a href="{{ route('admin.credentials.health') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                View Blockchain Health
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($credentials) ? route('admin.credentials.update', $credentials) : route('admin.credentials.store') }}" method="POST">
                        @csrf
                        @if(isset($credentials))
                            @method('PUT')
                        @endif

                        <div class="space-y-6">
                            <!-- BSC Private Key -->
                            <div>
                                <label for="bsc_private_key" class="block text-sm font-medium text-gray-700">BSC Private Key</label>
                                <input type="password" name="bsc_private_key" id="bsc_private_key" 
                                    value="{{ old('bsc_private_key', $credentials->bsc_private_key ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('bsc_private_key')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Wallet Address -->
                            <div>
                                <label for="wallet_address" class="block text-sm font-medium text-gray-700">Wallet Address</label>
                                <input type="text" name="wallet_address" id="wallet_address" 
                                    value="{{ old('wallet_address', $credentials->wallet_address ?? '') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('wallet_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mnemonic -->
                            <div>
                                <label for="mnemonic" class="block text-sm font-medium text-gray-700">Mnemonic</label>
                                <textarea name="mnemonic" id="mnemonic" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('mnemonic', $credentials->mnemonic ?? '') }}</textarea>
                                @error('mnemonic')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    {{ isset($credentials) ? 'Update Credentials' : 'Save Credentials' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-admin-layout> 