<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Support Ticket') }} #{{ $ticket->id }}
            </h2>
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                {{ $ticket->status === 'open' ? 'bg-green-100 text-green-800' : 
                   ($ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($ticket->status) }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Ticket Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $ticket->subject }}</h3>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>Created {{ $ticket->created_at->diffForHumans() }}</span>
                            <span class="mx-2">•</span>
                            <span>Category: {{ $ticket->category->name }}</span>
                            <span class="mx-2">•</span>
                            <span>Priority: {{ ucfirst($ticket->priority) }}</span>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="space-y-6">
                        @foreach($ticket->messages as $message)
                            <div class="flex {{ $message->is_staff ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-2xl {{ $message->is_staff ? 'bg-indigo-50' : 'bg-gray-50' }} rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="font-medium text-gray-900">
                                            {{ $message->is_staff ? 'Support Team' : auth()->user()->name }}
                                        </span>
                                        <span class="mx-2 text-gray-500">•</span>
                                        <span class="text-sm text-gray-500">{{ $message->created_at->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="text-gray-700">
                                        {{ $message->content }}
                                    </div>
                                    @if($message->attachments->isNotEmpty())
                                        <div class="mt-2">
                                            <h4 class="text-sm font-medium text-gray-900 mb-1">Attachments:</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($message->attachments as $attachment)
                                                    <a href="{{ route('support.attachment.download', $attachment) }}" 
                                                       class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                        </svg>
                                                        {{ $attachment->original_name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Reply Form -->
                    @if($ticket->status !== 'closed')
                        <div class="mt-8">
                            <form method="POST" action="{{ route('support.ticket.reply', $ticket) }}" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <div>
                                    <x-input-label for="message" :value="__('Your Reply')" />
                                    <textarea id="message" name="message" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required></textarea>
                                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="attachments" :value="__('Attachments (Optional)')" />
                                    <input type="file" id="attachments" name="attachments[]" multiple class="mt-1 block w-full" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                    <p class="mt-1 text-sm text-gray-500">You can attach up to 5 files. Maximum size: 5MB each.</p>
                                    <x-input-error :messages="$errors->get('attachments')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('support.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                                        Back to Support Center
                                    </a>

                                    <x-primary-button>
                                        {{ __('Send Reply') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-8 text-center">
                            <p class="text-gray-600">This ticket is closed. If you need further assistance, please create a new ticket.</p>
                            <a href="{{ route('support.ticket.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create New Ticket
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 