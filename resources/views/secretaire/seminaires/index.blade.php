@extends('layouts.app')
@section('title','Séminaires à traiter')

@section('content')
<div class="container mx-auto px-4 py-6 text-white">
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <span class="mr-2">📥</span> Séminaires à traiter
    </h2>

    @forelse ($seminaires as $seminaire)
        <div class="bg-white/20 p-4 rounded-lg mb-6 shadow">
            <h3 class="text-xl font-semibold">{{ $seminaire->theme }}</h3>
            <p class="text-sm text-gray-300">
                👤 {{ $seminaire->presentateur->name }} |
                📅 {{ $seminaire->date_presentation->format('d/m/Y') }}
            </p>

            <a href="{{ route('secretaire.seminaires.show',$seminaire) }}"
               class="inline-block mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
               🔍 Détails / Gérer
            </a>
        </div>
    @empty
        <p class="text-center text-gray-400 italic">Aucun séminaire à traiter.</p>
    @endforelse

    <div class="mt-4">{{ $seminaires->links() }}</div>
</div>
@endsection
