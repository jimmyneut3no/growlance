@props(['value'])

{{-- <label {{ $attributes->merge(['class' => 'form-label']) }}> --}}
<label {{ $attributes->merge(['class' => '']) }}>
    {{ $value ?? $slot }}
</label>
