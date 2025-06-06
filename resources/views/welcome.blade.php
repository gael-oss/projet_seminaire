{{-- resources/views/welcome.blade.php --}}
@extends('layouts.guest')

@section('title', 'Accueil IMSP')

@section('content')
<div class="text-center text-white">
    <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">
        🎓 Bienvenue sur IMSP
    </h1>
    <p class="text-lg mb-6">
        Plateforme de gestion et de consultation des séminaires de l’IMSP.
    </p>
    <div class="flex justify-center gap-4">
        <a href="{{ route('login') }}"
           class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
            🔐 Connexion
        </a>
        <a href="{{ route('register') }}"
           class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
            ✍️ Inscription
        </a>
    </div>
</div>
@endsection
