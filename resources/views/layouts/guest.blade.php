<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'DAWN-SNS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="min-h-screen dawn-auth-bg flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            {{-- ===== Brand Header（完成画像の上部） ===== --}}
            <div class="flex flex-col items-center mb-10">
                <div class="flex items-center justify-center gap-4">
                    <img
                        src="{{ asset('images/dawn-logo.png') }}"
                        alt="DAWN"
                        class="h-30 w-auto object-contain"
                    />
                </div>

                <div class="mt-3 text-white/90 text-lg tracking-wide">
                    Social Network Service
                </div>
            </div>

            {{-- ===== Auth Card ===== --}}
            <div class="dawn-auth-card p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
