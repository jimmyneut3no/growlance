@props(['active' => false, 'icon' => null, 'href'=>route('dashboard'), 'isDropdown' => false])

@php
$classes = ($active ?? false) ? 'mm-active' : '';
@endphp

<li class="{{$classes}}">
    <a href="{{($isDropdown ?? false)?'javascript:void(0);':$href;}}" class="{{($isDropdown ?? false)?'has-arrow':''}} ai-icon" aria-expanded="false">
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        <span class="nav-text">{{ $slot }}</span>
    </a>

    {{-- Render subnav if it's set --}}
    @isset($subnav)
        {{ $subnav }}
    @endisset
</li>
