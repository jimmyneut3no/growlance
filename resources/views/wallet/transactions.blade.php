<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction History') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3 class="text-lg font-medium text-primary mb-4">Referral Program</h3>
              
            </div><div class="col-6 text-right mb-4">
					<a href="{{ route('wallet.index') }}" class="btn btn-primary btn-rounded"><i class="ti-arrow-left"></i> Back to Wallet</a>
			</div>
        </div>
            
        <div class="card">
<div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Transaction Hash
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($transactions as $transaction)
                                @php
                                $color = '';
                                    switch ($transaction->type) {
                                        case 'deposit':
                                            $color = 'bg-green-100 text-green-800';
                                            break;
                                        case 'withdrawal':
                                            $color = 'bg-red-100 text-red-800';
                                            break;
                                        case 'fee':
                                            $color = 'bg-red-100 text-red-800';
                                            break;
                                        case 'stake':
                                            $color = 'bg-orange-100 text-orange';
                                            break;
                                        case 'unstake':
                                            $color = 'bg-orange-100 text-orange-800';
                                            break;
                                        
                                        default:
                                            $color = 'bg-gray-100 text-gray-800';
                                            break;
                                    }
                                @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ in_array($transaction->type, ['deposit', 'referral', 'reward'])? '+' : '-' }}{{ number_format($transaction->amount, 2) }} USDT
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                   ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            {{ $transaction->created_at->format('M d, Y H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($transaction->transaction_hash)
                                                <a href="https://bscscan.com/tx/{{ $transaction->transaction_hash }}" 
                                                   target="_blank" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    {{ Str::limit($transaction->transaction_hash, 16) }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No transactions found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>

                    </div>


                </div>
            </div>

</x-app-layout> 