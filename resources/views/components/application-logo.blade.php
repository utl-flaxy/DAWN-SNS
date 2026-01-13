@php
    $path = public_path('images/dawn-logo.png');
@endphp

@if (file_exists($path))
    <img src="{{ asset('images/dawn-logo.png') }}" {{ $attributes->merge(['class' => '']) }} alt="DAWN" />
@else
    <div {{ $attributes->merge(['class' => 'rounded bg-white/20 flex items-center justify-center text-white font-bold']) }}>
        D
    </div>
@endif
