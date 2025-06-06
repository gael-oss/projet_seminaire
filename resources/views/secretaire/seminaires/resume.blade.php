@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Résumé du Séminaire</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Thème</label>
                <div class="mt-1 text-gray-900 font-semibold">{{ $seminaire->theme }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Présentateur</label>
                <div class="mt-1 text-gray-900">{{ $seminaire->presentateur->name }}</div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Date de présentation</label>
                <div class="mt-1 text-gray-900">
                    {{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Statut</label>
                <div class="mt-1">
                    <span class="inline-block px-3 py-1 rounded-full text-white text-xs
                        @if($seminaire->statut == 'soumis') bg-yellow-500
                        @elseif($seminaire->statut == 'validé') bg-green-600
                        @elseif($seminaire->statut == 'publié') bg-blue-600
                        @else bg-red-600 @endif">
                        {{ ucfirst($seminaire->statut) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Résumé</label>
            <div class="bg-gray-100 text-gray-800 p-4 rounded shadow-sm leading-relaxed">
                {!! nl2br(e($seminaire->resume)) !!}
            </div>
        </div>

        <div class="mt-6 flex flex-col md:flex-row md:items-center gap-4">
            <form method="POST" action="{{ route('seminaires.valider', $seminaire) }}">
                @csrf
                <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700 text-sm">
                    ✅ Valider
                </button>
            </form>

            <form method="POST" action="{{ route('seminaires.rejeter', $seminaire) }}">
                @csrf
                <input type="text" name="motif" placeholder="Motif du rejet" required
                    class="border px-3 py-1 rounded text-sm text-gray-800 focus:ring focus:border-blue-300">
                <button type="submit" class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 text-sm">
                    ❌ Rejeter
                </button>
            </form>

            <a href="{{ route('secretaire.seminaires') }}"
                class="ml-auto text-blue-600 hover:underline text-sm">
                ← Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
