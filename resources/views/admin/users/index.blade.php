@extends('layouts.app')

@section('content')
<div class="container">
    <h1>👥 Gestion des utilisateurs</h1>

    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle actuel</th>
                <th>Changer le rôle</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <select name="role">
                            <option value="etudiant" {{ $user->role === 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                            <option value="presentateur" {{ $user->role === 'presentateur' ? 'selected' : '' }}>Présentateur</option>
                            <option value="secretaire" {{ $user->role === 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button type="submit">✅ Modifier</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
