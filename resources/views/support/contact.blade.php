<x-app-layout>
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Support Center') }}
        </h2>
    </x-slot>
    <div class="container">
            <div class="card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-2xl font-semibold mb-2">Contact Support</h2>
                        <p class="text-gray-600">Need help? Send us a message and we'll get back to you as soon as possible.</p>
                    </div>

                    <form id="support-contact-form" method="POST" action="{{ route('support.contact.send') }}" class="space-y-6">
                        @csrf
                        
                        {{-- <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="subject" id="subject" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Brief description of your issue">
                        </div> --}}
                        <div>
                            <x-input-label for="name" :value="__('Subject')" class="block text-sm font-medium text-gray-700" />
                            <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" required autofocus autocomplete="subject" placeholder="Brief description of your issue" />
                            <x-input-error class="mt-2" :messages="$errors->get('subject')" />
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="message" id="message" rows="4" required
                                class="form-control input-default mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Please describe your issue in detail"></textarea>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Send Message
                            </button>
                        </div>
                    </form>

                    <div id="form-message" class="mt-4" style="display: none;">
                        <div class="alert alert-success" role="alert" style="display: none;">
                            <i class="icon-check-circle me-2"></i>
                            <span class="message-text"></span>
                        </div>
                        <div class="alert alert-danger" role="alert" style="display: none;">
                            <i class="icon-x-circle me-2"></i>
                            <span class="message-text"></span>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            var form = $('#support-contact-form');
            var formMessage = $('#form-message');
            var successAlert = formMessage.find('.alert-success');
            var errorAlert = formMessage.find('.alert-danger');

            form.submit(function(e) {
                e.preventDefault();
                
                // Hide any existing alerts
                successAlert.hide();
                errorAlert.hide();
                formMessage.hide();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData
                })
                .done(function(response) {
                    // Show success message
                    formMessage.show();
                    successAlert.show();
                    successAlert.find('.message-text').text(response.message);
                    
                    // Clear form
                    form.find('input, textarea').val('');
                    
                    // Hide success message after 5 seconds
                    setTimeout(function() {
                        formMessage.fadeOut();
                    }, 5000);
                })
                .fail(function(data) {
                    // Show error message
                    formMessage.show();
                    errorAlert.show();
                    
                    if (data.responseJSON && data.responseJSON.message) {
                        errorAlert.find('.message-text').text(data.responseJSON.message);
                    } else {
                        errorAlert.find('.message-text').text('Oops! An error occurred and your message could not be sent.');
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 