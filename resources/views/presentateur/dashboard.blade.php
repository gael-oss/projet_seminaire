@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center text-success">🎤 Tableau de bord du Présentateur</h1>

    @if ($seminaires->isEmpty())
        <div class="alert alert-info">
            Aucun séminaire à venir. Soumettez un nouveau séminaire !
        </div>
    @else
        <div class="list-group">
            @foreach ($seminaires as $seminaire)
                <div class="list-group-item">
                    <h5 class="mb-1">{{ $seminaire->theme }}</h5>
                    <p class="mb-1">📅 {{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</p>
                    <small class="text-muted">Statut : {{ ucfirst($seminaire->statut) }}</small>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
