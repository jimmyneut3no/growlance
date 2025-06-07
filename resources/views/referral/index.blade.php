<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Referral Program') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="text-lg font-medium text-primary mb-4">Referral Program</h3>
            </div>
            <div class="col-12">
                <div class="card h-auto">
                    <div class="card-body">
                        <!-- Referral Link Section -->
                        <div class="row mb-4 d-flex justify-content-center">
                            <div class="col-md-8">
                                        <h5 class="card-title">Your Referral Link</h5>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="{{ $referralLink }}" readonly>
                                            <button class="btn btn-primary" onclick="copyToClipboard('{{ $referralLink }}')">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                            </div>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card" style="border: 2px solid grey;">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Withdrawn</h5>
                                        <h3 class="mb-0">{{ number_format($earnings['total'], 2) }} USDT</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card" style="border: 2px solid grey;">
                                    <div class="card-body ">
                                        <h5 class="card-title">Pending Withdrawal</h5>
                                        <h3 class="mb-0">{{ number_format($earnings['pending'], 2) }} USDT</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card"  style="border: 2px solid grey;">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Referrals</h5>
                                        <h3 class="mb-0">{{ $earnings['by_level'][1]['referrals'] + $earnings['by_level'][2]['referrals'] + $earnings['by_level'][3]['referrals'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Level-wise Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="card-title mb-0">Level 1</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Earnings:</span>
                                            <strong>{{ number_format($earnings['by_level'][1]['total'], 2) }} USDT</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Pending Earnings:</span>
                                            <strong>{{ number_format($earnings['by_level'][1]['pending'], 2) }} USDT</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Total Referrals:</span>
                                            <strong>{{ $earnings['by_level'][1]['referrals'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="card-title mb-0">Level 2</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Earnings:</span>
                                            <strong>{{ number_format($earnings['by_level'][2]['total'], 2) }} USDT</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Pending Earnings:</span>
                                            <strong>{{ number_format($earnings['by_level'][2]['pending'], 2) }} USDT</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Total Referrals:</span>
                                            <strong>{{ $earnings['by_level'][2]['referrals'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="card-title mb-0">Level 3</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Total Earnings:</span>
                                            <strong>{{ number_format($earnings['by_level'][3]['total'], 2) }} USDT</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Pending Earnings:</span>
                                            <strong>{{ number_format($earnings['by_level'][3]['pending'], 2) }} USDT</strong>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Total Referrals:</span>
                                            <strong>{{ $earnings['by_level'][3]['referrals'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Earnings Table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Recent Earnings</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>User</th>
                                                <th>Level</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentEarnings as $earning)
                                            <tr>
                                                <td>{{ $earning->created_at->format('M d, Y H:i') }}</td>
                                                <td>{{ $earning->user->name }}</td>
                                                <td>Level {{ $earning->level }}</td>
                                                <td>{{ number_format($earning->amount, 2) }} USDT</td>
                                                <td>
                                                    <span class="badge bg-{{ $earning->status === 'paid' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($earning->status?'Withdrawn':$earning->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No earnings yet</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{ $recentEarnings->links() }}
                            </div>
                        </div>

                        <!-- Withdraw Button -->
                        @if($earnings['pending'] > 0)
                        <div class="text-center mt-4">
                            <form action="{{ route('referral.withdraw') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Withdraw Earnings to Main Balance ({{ number_format($earnings['pending'], 2) }} USDT)
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            toastr.success('Referral link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }
    </script>
    @endpush
</x-app-layout>