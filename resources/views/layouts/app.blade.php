{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IMSP Séminaires')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Font Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Boxicons (icônes) --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    {{-- 1) IMPORT du CSS principal contenant le background --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body class="flex flex-col min-h-screen">

    {{-- Barre de navigation --}}
    <header class="site-header">
        <nav class="nav">
            <a href="{{ url('/') }}" class="nav-logo">IMSP</a>
            <ul class="nav-links">
                @auth
                    @if(auth()->user()->role === 'secretaire')
                        <li><a href="{{ route('secretaire.dashboard') }}">Secrétaire</a></li>
                    @endif
                    @if(auth()->user()->role === 'presentateur')
                        <li><a href="{{ route('presentateur.dashboard') }}">Présentateur</a></li>
                    @endif
                    @if(auth()->user()->role === 'etudiant')
                        <li><a href="{{ route('etudiant.dashboard') }}">Étudiant</a></li>
                    @endif
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    {{-- Conteneur centré pour le contenu --}}
    <main class="site-content">
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="site-footer">
        &copy; {{ date('Y') }} IMSP — Tous droits réservés.
    </footer>

    @stack('scripts')
</body>
</html>
