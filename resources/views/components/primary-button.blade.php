<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary mb-2']) }}>
    {{ $slot }}
</button>
