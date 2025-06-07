<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Referral Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.referral-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Referral Percentages -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Referral Percentages</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="level_1_percentage" class="block text-sm font-medium text-gray-700">Level 1 Percentage (%)</label>
                                    <input type="number" step="0.01" name="level_1_percentage" id="level_1_percentage" 
                                        value="{{ old('level_1_percentage', $settings['level_1_percentage'] ?? 5) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <p class="mt-1 text-sm text-gray-500">Direct referrals</p>
                                    @error('level_1_percentage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="level_2_percentage" class="block text-sm font-medium text-gray-700">Level 2 Percentage (%)</label>
                                    <input type="number" step="0.01" name="level_2_percentage" id="level_2_percentage" 
                                        value="{{ old('level_2_percentage', $settings['level_2_percentage'] ?? 3) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <p class="mt-1 text-sm text-gray-500">Referrals of referrals</p>
                                    @error('level_2_percentage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="level_3_percentage" class="block text-sm font-medium text-gray-700">Level 3 Percentage (%)</label>
                                    <input type="number" step="0.01" name="level_3_percentage" id="level_3_percentage" 
                                        value="{{ old('level_3_percentage', $settings['level_3_percentage'] ?? 1) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <p class="mt-1 text-sm text-gray-500">Third level referrals</p>
                                    @error('level_3_percentage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Referral Structure -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-4">Referral Structure</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-semibold">1</div>
                                        <div class="ml-4">
                                            <p class="font-medium">Level 1 (Direct Referrals)</p>
                                            <p class="text-sm text-gray-500">Users directly referred by you</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-semibold">2</div>
                                        <div class="ml-4">
                                            <p class="font-medium">Level 2 (Indirect Referrals)</p>
                                            <p class="text-sm text-gray-500">Users referred by your Level 1 referrals</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-semibold">3</div>
                                        <div class="ml-4">
                                            <p class="font-medium">Level 3 (Deep Referrals)</p>
                                            <p class="text-sm text-gray-500">Users referred by your Level 2 referrals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 