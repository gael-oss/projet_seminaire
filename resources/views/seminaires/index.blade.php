@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des séminaires soumis</h1>

    <!-- Message de succès s'il existe -->
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des séminaires -->
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Thème</th>
                <th>Présentateur</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminaires as $seminaire)
                <tr>
                    <td>{{ $seminaire->theme }}</td>
                    <td>{{ $seminaire->presentateur->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</td>
                    <td>
    {{ ucfirst($seminaire->statut) }}

    @if(auth()->user()->role === 'secretaire')
        @if($seminaire->statut === 'en_attente')
            <form action="{{ route('seminaires.valider', $seminaire->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Valider</button>
            </form>
        @endif

        @if($seminaire->statut === 'valide')
            <form action="{{ route('seminaires.publier', $seminaire->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Publier</button>
            </form>
        @endif
    @endif
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
