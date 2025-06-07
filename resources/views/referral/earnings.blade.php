@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Earnings History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Level</th>
                                    <th>Source</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($earnings as $earning)
                                <tr>
                                    <td>{{ $earning->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                {!! $earning->user->getAvatar() !!}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $earning->user->name }}</h6>
                                                <small class="text-muted">{{ $earning->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Level {{ $earning->level }}</span>
                                    </td>
                                    <td>
                                        @if($earning->source_type === 'stake')
                                            <span class="badge bg-primary">Staking</span>
                                        @elseif($earning->source_type === 'deposit')
                                            <span class="badge bg-success">Deposit</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($earning->amount, 2) }} USDT</td>
                                    <td>
                                        <span class="badge bg-{{ $earning->status === 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($earning->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No earnings history yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $earnings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 