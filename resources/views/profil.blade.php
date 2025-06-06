@extends('layouts.app')

@section('content')
<div class="container">
    <h1>👤 Mon profil</h1>

    <!-- Message de confirmation -->
    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <!-- Formulaire de modification du nom et email -->
    <form method="POST" action="{{ route('profil.update') }}">
        @csrf
        @method('PUT')

        <div class="mt-4">
            <label>Nom :</label><br>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        <div class="mt-4">
            <label>Email :</label><br>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <button type="submit" style="margin-top: 10px;">💾 Enregistrer</button>
    </form>

    <hr style="margin: 30px 0;">

    <!-- Formulaire de changement de mot de passe -->
    <form method="POST" action="{{ route('profil.password') }}">
        @csrf
        @method('PUT')

        <div class="mt-4">
            <label>Mot de passe actuel :</label><br>
            <input type="password" name="current_password" required>
        </div>

        <div class="mt-4">
            <label>Nouveau mot de passe :</label><br>
            <input type="password" name="new_password" required>
        </div>

        <div class="mt-4">
            <label>Confirmer nouveau mot de passe :</label><br>
            <input type="password" name="new_password_confirmation" required>
        </div>

        <button type="submit" style="margin-top: 10px;">🔐 Changer le mot de passe</button>
    </form>
</div>
@endsection
