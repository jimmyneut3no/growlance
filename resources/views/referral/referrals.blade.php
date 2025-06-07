@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Referrals</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Date Joined</th>
                                    <th>Total Staked</th>
                                    <th>Active Stakes</th>
                                    <th>Referrals</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $referral)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-2">
                                                {!! $referral->getAvatar() !!}
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $referral->name }}</h6>
                                                <small class="text-muted">{{ $referral->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $referral->created_at->format('M d, Y') }}</td>
                                    <td>{{ number_format($referral->stakes_sum_amount ?? 0, 2) }} USDT</td>
                                    <td>{{ $referral->stakes_count }}</td>
                                    <td>{{ $referral->referrals_count }}</td>
                                    <td>
                                        @if($referral->stakes_count > 0)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No referrals yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $referrals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 