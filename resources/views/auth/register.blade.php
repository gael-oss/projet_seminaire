@extends('layouts.app')

@section('title','Inscription')

@section('content')
  <div class="register-wrapper">
    <h2 class="form-title">Créer un compte</h2>

    <form method="POST" action="{{ route('register') }}" class="form-box">
      @csrf

      <div class="input-box">
        <label for="name">Nom complet</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        @error('name') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="input-box">
        <label for="email">Adresse email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="input-box">
        <label for="role">Rôle</label>
        <select id="role" name="role" required>
          <option value="">-- Sélectionnez --</option>
          <option value="presentateur" {{ old('role')=='presentateur'?'selected':'' }}>Présentateur</option>
          <option value="etudiant"    {{ old('role')=='etudiant'   ?'selected':'' }}>Étudiant</option>
          <option value="admin"       {{ old('role')=='admin'      ?'selected':'' }}>Administrateur</option>
          <option value="secretaire"  {{ old('role')=='secretaire' ?'selected':'' }}>Secrétaire</option>
        </select>
        @error('role') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="input-box">
        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password" required>
        @error('password') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="input-box">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
      </div>

      <button type="submit" class="btn submit-btn">S’inscrire</button>

      <p class="register-link">Déjà inscrit ? <a href="{{ route('login') }}">Connexion</a></p>
    </form>
  </div>
@endsection
