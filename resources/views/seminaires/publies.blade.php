@extends('layouts.app')

@section('title', 'Séminaires publiés')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6">

        <h2 class="text-3xl font-bold text-gray-800 mb-6">📚 Liste des séminaires publiés</h2>

        {{-- Filtres --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <input type="text" name="theme" value="{{ request('theme') }}"
                class="border border-gray-300 rounded px-3 py-2 w-full"
                placeholder="🔍 Filtrer par thème">

            <input type="text" name="presentateur" value="{{ request('presentateur') }}"
                class="border border-gray-300 rounded px-3 py-2 w-full"
                placeholder="👤 Par nom du présentateur">

            <input type="date" name="date" value="{{ request('date') }}"
                class="border border-gray-300 rounded px-3 py-2 w-full">
            
            <div class="md:col-span-3 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    🔎 Appliquer les filtres
                </button>
            </div>
        </form>

        @if($seminaires->isEmpty())
            <p class="text-gray-600 italic">Aucun séminaire ne correspond aux critères.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-collapse border-gray-300 text-sm">
                    <thead class="bg-gray-100 text-left text-gray-700">
                        <tr>
                            <th class="border px-4 py-2">Thème</th>
                            <th class="border px-4 py-2">Présentateur</th>
                            <th class="border px-4 py-2">Résumé</th>
                            <th class="border px-4 py-2">Date</th>
                            <th class="border px-4 py-2 text-center">Fichier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seminaires as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $s->theme }}</td>
                                <td class="border px-4 py-2">{{ $s->presentateur->name }}</td>
                                <td class="border px-4 py-2 text-gray-600">{!! nl2br(e(Str::limit($s->resume, 100))) !!}</td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($s->date_presentation)->format('d/m/Y') }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if($s->fichier_final)
                                        <a href="{{ route('etudiant.telecharger', $s) }}"
                                           class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                            📥 Télécharger
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Indisponible</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection
