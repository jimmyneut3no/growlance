<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container">
        		<!--**********************************
            Content body start
        ***********************************-->
        <div class="row">
            <div class="col-12">
                <x-profile-settings title="Overview" />
				

		<!--**********************************
            Content body end
        ***********************************-->

            <div class="card h-auto overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="max-w-2xl mx-auto">
                        <!-- Profile Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Information</h3>
                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    @if (session('status') === 'profile-updated')
                                        <p class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>
</x-app-layout> 