{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'IMSP')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Font Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Boxicons --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    {{-- 1) IMPORT du CSS principal avec le background --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body class="flex flex-col min-h-screen">

    {{-- Header centré (logo/Titre) --}}
    <header class="flex justify-center py-6">
        <a href="{{ url('/') }}" class="text-3xl font-bold text-white hover:text-indigo-200">
            <i class="bx bxs-graduation"></i> IMSP
        </a>
    </header>

    {{-- Conteneur principal centré --}}
    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    {{-- Footer discret --}}
    <footer class="site-footer bg-black/50">
        &copy; {{ date('Y') }} IMSP — Tous droits réservés.
    </footer>

    @stack('scripts')
</body>
</html>
