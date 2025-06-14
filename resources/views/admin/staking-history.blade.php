<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Staking History') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Search and Filter -->
                    {{-- <div class="mb-6">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="Search by name, email, or username">
                            </div>
                            <div>
                                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                    Search
                                </button>
                            </div>
                        </form>
                    </div> --}}

                 <!-- Recent Transactions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Staking History</h3>
                            <a href="{{route('admin.dashboard')}}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                             < Back to Dashboard
                            </a>
                        </div>
                    </div>
               <div class="divide-y divide-gray-100">
                        @foreach($allStakes as $stake)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 bg-blue-100 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $stake->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $stake->stakingPlan->name }} • {{ $stake->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">${{ number_format($stake->amount, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $stake->created_at->format('M j, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $allStakes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 