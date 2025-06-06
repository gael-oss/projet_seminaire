@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📚 Séminaires publiés</h1>

    <!-- Formulaire de filtres -->
    <form method="GET" action="{{ route('seminaires.public') }}" style="margin-bottom: 20px;">
        <input type="text" name="theme" placeholder="Thème" value="{{ request('theme') }}">
        <input type="text" name="presentateur" placeholder="Présentateur" value="{{ request('presentateur') }}">
        <input type="date" name="date" value="{{ request('date') }}">
        <button type="submit">🔍 Filtrer</button>
        <a href="{{ route('seminaires.public') }}">🔄 Réinitialiser</a>
    </form>

    <!-- Liens PDF et Planning (réservés au secrétaire) -->
    @auth
        @if(auth()->user()->role === 'secretaire')
            <div style="margin-bottom: 15px;">
                <a href="{{ route('seminaires.exportPdf') }}">📄 Télécharger en PDF</a> |
                <a href="{{ route('seminaires.planning') }}">📅 Voir le planning du mois</a>
            </div>
        @endif
    @endauth

    @if($seminaires->isEmpty())
        <p>Aucun séminaire publié pour le moment.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Thème</th>
                    <th>Présentateur</th>
                    <th>Date</th>
                    <th>Résumé</th>
                    <th>Fichier</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seminaires as $seminaire)
                    <tr>
                        <td>{{ $seminaire->theme }}</td>
                        <td>{{ $seminaire->presentateur->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($seminaire->resume, 100) }}</td>
                        <td>
                            @if($seminaire->fichier)
                                <a href="{{ asset('storage/presentations/' . $seminaire->fichier) }}" target="_blank">📥 Télécharger</a>
                            @else
                                Non disponible
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
