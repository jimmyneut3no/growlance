<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            {{ __('Advanced') }}
        </h2>
    </x-slot>

    <div class="container">
        		<!--**********************************
            Content body start
        ***********************************-->
        <div class="row">
            <div class="col-12">
                <x-profile-settings title="Advanced" />
				

		<!--**********************************
            Content body end
        ***********************************-->

            <div class="p-4 sm:p-8 card shadow-sm sm:rounded-lg h-auto">
                    @include('profile.partials.delete-user-form')
            </div>
                    </div>
            </div>

        </div>



</x-app-layout> 