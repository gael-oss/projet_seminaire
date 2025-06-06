@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Demandes de séminaires</h2>

    @forelse($seminaires as $seminaire)
        <div class="bg-white shadow rounded p-4 mb-4">
            <h3 class="text-lg font-semibold">{{ $seminaire->theme }}</h3>
            <p><strong>Présentateur :</strong> {{ $seminaire->presentateur->name }}</p>
            <p><strong>Date souhaitée :</strong> {{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</p>

            <div class="flex gap-4 mt-3">
                <form action="{{ route('secretaire.demande.valider', $seminaire) }}" method="POST">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded">Valider</button>
                </form>

                <form action="{{ route('secretaire.demande.rejeter', $seminaire) }}" method="POST">
                    @csrf
                    <button class="bg-red-600 text-white px-4 py-2 rounded">Rejeter</button>
                </form>
            </div>
        </div>
    @empty
        <p>Aucune demande en attente.</p>
    @endforelse
</div>
@endsection
