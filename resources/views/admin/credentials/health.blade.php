 <x-admin-layout>
    <x-slot name="header">
         <div class="flex justify-between items-center">
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                 {{ __('System Health') }}
            </h2>
           <form method="POST" action="{{ route('admin.credentials.restart') }}">
            @csrf
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
               Restart Server
            </button>
        </form>
         </div>
    </x-slot>

    <div class="py-12">
      <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">

            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="h-3 w-3 rounded-full {{ $healthData['status'] === 'ok' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        </div>
                        <div class="ml-3">
                            <h2 class="text-lg font-medium text-gray-900">Overall Status</h2>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($healthData['timestamp'])->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <span class="px-3 py-1 {{ $healthData['status'] === 'ok' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-sm font-medium rounded-full">
                            {{ $healthData['status'] }}
                        </span>
                        <p class="ml-3 text-sm text-gray-600">
                            {{ $healthData['message'] ?? 'USDT wallet API status' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Components Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- API Status Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                        <h2 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-server text-blue-500 mr-2"></i>
                            API Status
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $healthData['components']['api']['status'] === 'ok' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $healthData['components']['api']['status'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Uptime</span>
                                <span class="text-sm text-gray-600">
                                    {{ number_format($healthData['components']['api']['uptime'], 2) }} seconds
                                </span>
                            </div>
                        </div>
                        
                        <h3 class="text-md font-medium text-gray-700 mb-2">Memory Usage</h3>
                        <div class="space-y-2">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">RSS</span>
                                    <span class="text-gray-800">
                                        {{ number_format($healthData['components']['api']['memoryUsage']['rss'] / 1024 / 1024, 2) }} MB
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $rssPercent = min(($healthData['components']['api']['memoryUsage']['rss'] / 10000000) * 100, 100);
                                    @endphp
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $rssPercent }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Heap Total</span>
                                    <span class="text-gray-800">
                                        {{ number_format($healthData['components']['api']['memoryUsage']['heapTotal'] / 1024 / 1024, 2) }} MB
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $heapTotalPercent = min(($healthData['components']['api']['memoryUsage']['heapTotal'] / 10000000) * 100, 100);
                                    @endphp
                                    <div class="bg-blue-400 h-2 rounded-full" style="width: {{ $heapTotalPercent }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Heap Used</span>
                                    <span class="text-gray-800">
                                        {{ number_format($healthData['components']['api']['memoryUsage']['heapUsed'] / 1024 / 1024, 2) }} MB
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    @php
                                        $heapUsedPercent = min(($healthData['components']['api']['memoryUsage']['heapUsed'] / 10000000) * 100, 100);
                                    @endphp
                                    <div class="bg-blue-300 h-2 rounded-full" style="width: {{ $heapUsedPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blockchain Status Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-purple-50">
                        <h2 class="text-lg font-medium text-gray-900">
                            <i class="fas fa-link text-purple-500 mr-2"></i>
                            Blockchain Status
                        </h2>
                    </div>
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $healthData['components']['blockchain']['status'] === 'ok' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $healthData['components']['blockchain']['status'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Network</span>
                                <span class="text-sm text-gray-600">
                                    {{ $healthData['components']['blockchain']['network'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Chain ID</span>
                                <span class="text-sm text-gray-600">
                                    {{ $healthData['components']['blockchain']['chainId'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Block Number</span>
                                <span class="text-sm text-gray-600">
                                    {{ number_format($healthData['components']['blockchain']['blockNumber']) }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-600">Gas Price</span>
                                <span class="text-sm text-gray-600">
                                    {{ $healthData['components']['blockchain']['gasPrice'] }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Last Checked</span>
                                <span class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($healthData['components']['blockchain']['lastChecked'])->format('H:i:s') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refresh Button -->
            <div class="mt-6 flex justify-end">
                <button onclick="window.location.reload()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i> Refresh Data
                </button>
            </div>
        </div>
    </div>
    </div>

    <!-- Auto-refresh script -->
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(() => {
            window.location.reload();
        }, 30000);
    </script>

</x-admin-layout> 