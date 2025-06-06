@extends('layouts.app')
@section('title','Gérer un séminaire')

@section('content')
<div class="container mx-auto px-4 py-6 text-white">
    <h2 class="text-2xl font-bold mb-4 flex items-center">
        <span class="mr-2">🎯</span> Gestion du séminaire
    </h2>

    <div class="bg-white/20 p-6 rounded shadow">
        <p class="text-lg font-semibold">{{ $seminaire->theme }}</p>
        <p class="text-sm text-gray-300 mb-1">
            👤 Présentateur : {{ $seminaire->presentateur->name }}
        </p>
        <p class="text-sm text-gray-300 mb-3">
            📅 Date : {{ $seminaire->date_presentation->format('d/m/Y') }}
        </p>

        <h3 class="font-semibold mb-1">Résumé :</h3>
        <div class="bg-white/10 p-4 rounded mb-4 whitespace-pre-line">
            {{ $seminaire->resume ?? '—' }}
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4">
            {{-- Valider --}}
            <form action="{{ route('secretaire.seminaires.valider',$seminaire) }}" method="POST">
                @csrf
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                    ✅ Valider
                </button>
            </form>

            {{-- Rejeter --}}
            <form action="{{ route('secretaire.seminaires.reject',$seminaire) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="motif" required
                       placeholder="Motif du rejet"
                       class="px-2 py-1 bg-white/20 text-white rounded text-sm placeholder-gray-300">
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                    ❌ Rejeter
                </button>
            </form>

            {{-- Publier (si déjà validé) --}}
            @if($seminaire->statut === 'validé')
                <form action="{{ route('secretaire.seminaires.publier',$seminaire) }}" method="POST">
                    @csrf
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                        📢 Publier
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
