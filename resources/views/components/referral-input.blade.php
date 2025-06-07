@props(['disabled' => false])

<div class="mt-4">
    <x-input-label for="referral_code" :value="__('Referral Code (Optional)')" />
    <x-text-input id="referral_code" class="block mt-1 w-full" type="text" name="referral_code" :value="old('referral_code', request('ref'))" :disabled="$disabled" />
    <x-input-error :messages="$errors->get('referral_code')" class="mt-2" />
</div> 