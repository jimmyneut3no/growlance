<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('KYC Verification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(auth()->user()->kyc_status === 'verified')
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">KYC Verified</h3>
                            <p class="mt-1 text-sm text-gray-500">Your account has been verified successfully.</p>
                        </div>
                    @elseif(auth()->user()->kyc_status === 'pending')
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">KYC Under Review</h3>
                            <p class="mt-1 text-sm text-gray-500">Your documents are being reviewed. This usually takes 1-2 business days.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('kyc.submit') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="full_name" :value="__('Full Name')" />
                                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_type" :value="__('ID Type')" />
                                <select id="id_type" name="id_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="passport">Passport</option>
                                    <option value="national_id">National ID</option>
                                    <option value="drivers_license">Driver's License</option>
                                </select>
                                <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_number" :value="__('ID Number')" />
                                <x-text-input id="id_number" name="id_number" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_front" :value="__('ID Front Image')" />
                                <input type="file" id="id_front" name="id_front" accept="image/*" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('id_front')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_back" :value="__('ID Back Image')" />
                                <input type="file" id="id_back" name="id_back" accept="image/*" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('id_back')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="selfie" :value="__('Selfie with ID')" />
                                <input type="file" id="selfie" name="selfie" accept="image/*" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('selfie')" class="mt-2" />
                            </div>

                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">Important Information</h4>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        All documents must be clear and legible
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        ID must be valid and not expired
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Selfie must clearly show your face and ID
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Do not edit or modify any documents
                                    </li>
                                </ul>
                            </div>

                            <x-primary-button>
                                {{ __('Submit KYC') }}
                            </x-primary-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 