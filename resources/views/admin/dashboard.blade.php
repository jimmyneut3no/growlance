<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Welcome back, Administrator</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm bg-gray-100 px-3 py-1.5 rounded-full">
                    <span class="font-medium">{{ now()->format('l') }},</span>
                    <span>{{ now()->format('F j, Y') }}</span>
                </div>
                {{-- <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button> --}}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 shadow-sm border border-blue-100 p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-blue-800">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_users']) }}</p>
                            <div class="flex items-center mt-2">
                                {{-- <span class="bg-blue-200 text-blue-800 text-xs px-2 py-0.5 rounded-full">+12% from last month</span> --}}
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-lg shadow-xs">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Staked -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5 shadow-sm border border-green-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-green-800">Total Staked</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($stats['total_staked_amount'], 2) }}</p>
                            <div class="flex items-center mt-2">
                                {{-- <span class="bg-green-200 text-green-800 text-xs px-2 py-0.5 rounded-full">+8.5% from last month</span> --}}
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-lg shadow-xs">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Deposits -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 shadow-sm border border-purple-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-purple-800">Total Deposits</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($stats['total_deposits'], 2) }}</p>
                            <div class="flex items-center mt-2">
                                {{-- <span class="bg-purple-200 text-purple-800 text-xs px-2 py-0.5 rounded-full">+15.2% from last month</span> --}}
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-lg shadow-xs">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Referral Earnings -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-5 shadow-sm border border-amber-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-amber-800">Referral Earnings</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($stats['total_referral_earnings'], 2) }}</p>
                            <div class="flex items-center mt-2">
                                {{-- <span class="bg-amber-200 text-amber-800 text-xs px-2 py-0.5 rounded-full">+22% from last month</span> --}}
                            </div>
                        </div>
                        <div class="p-3 bg-white rounded-lg shadow-xs">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Monthly Overview (Chart + Stats) -->
                <div class="bg-white rounded-xl shadow-sm border-b border-gray-100 p-6 lg:col-span-1">
                    <div class="border-b border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Monthly Overview</h3>
                    </div>
                    </div>
                
                    
                                        <div class="divide-y divide-gray-100">

                        <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">New Users</p>
                                    <p class="text-lg font-bold text-gray-900">{{ number_format($monthlyStats['new_users']) }}</p>
                                </div>
                            </div>
                            {{-- <span class="text-sm font-medium text-green-600">+{{ rand(5, 15) }}%</span> --}}
                        </div>
                        
                        <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">New Stakes</p>
                                    <p class="text-lg font-bold text-gray-900">{{ number_format($monthlyStats['new_stakes']) }}</p>
                                </div>
                            </div>
                            {{-- <span class="text-sm font-medium text-green-600">+{{ rand(5, 15) }}%</span> --}}
                        </div>
                        
                        <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-purple-100 rounded-lg">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600">New Deposits</p>
                                    <p class="text-lg font-bold text-gray-900">${{ number_format($monthlyStats['new_deposits'], 2) }}</p>
                                </div>
                            </div>
                            {{-- <span class="text-sm font-medium text-green-600">+{{ rand(5, 15) }}%</span> --}}
                        </div>
                    </div>
                </div>

                <!-- Recent Stakes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Recent Stakes</h3>
                            <a href="{{route('admin.staking-history')}}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                View all
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($recentStakes as $stake)
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

                <!-- Recent Transactions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Recent Transactions</h3>
                            <a href="{{route('admin.transactions')}}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                View all
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($recentTransactions as $transaction)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <div class="p-2 {{ $transaction->type === 'deposit' ? 'bg-green-100' : 'bg-red-100' }} rounded-lg">
                                        <svg class="w-5 h-5 {{ $transaction->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $transaction->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ ucfirst($transaction->type) }} • {{ $transaction->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold {{ $transaction->type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $transaction->created_at->format('M j, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>