<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

<section class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg">
    <header>
        <h2 class="text-lg font-medium">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <label for="update_password_current_password" class="block text-sm font-medium">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full px-4 py-2 border border-gray-700 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-500"
                   autocomplete="current-password">
            @if ($errors->updatePassword->get('current_password'))
                <p class="mt-1 text-sm text-red-400">
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="update_password_password" class="block text-sm font-medium">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full px-4 py-2 border border-gray-700 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-500"
                   autocomplete="new-password">
            @if ($errors->updatePassword->get('password'))
                <p class="mt-1 text-sm text-red-400">
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @endif
        </div>

        <div class="space-y-2">
            <label for="update_password_password_confirmation" class="block text-sm font-medium">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full px-4 py-2 border border-gray-700 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-500"
                   autocomplete="new-password">
            @if ($errors->updatePassword->get('password_confirmation'))
                <p class="mt-1 text-sm text-red-400">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" style="background-color: purple" 
                    class="px-4 py-2 text-white rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" 
                   x-show="show" 
                   x-transition 
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
</x-admin-layout>
