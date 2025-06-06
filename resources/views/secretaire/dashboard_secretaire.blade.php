@extends('layouts.app')

@section('title', 'Dashboard Secrétaire')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">

        {{-- Titre --}}
        <h2 class="text-3xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            📊 Tableau de bord du secrétaire
        </h2>

        {{-- Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-100 text-blue-800 p-4 rounded shadow text-center">
                <h3 class="text-lg font-semibold">Total séminaires</h3>
                <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-green-100 text-green-800 p-4 rounded shadow text-center">
                <h3 class="text-lg font-semibold">Validés</h3>
                <p class="text-2xl font-bold">{{ $stats['valides'] }}</p>
            </div>
            <div class="bg-purple-100 text-purple-800 p-4 rounded shadow text-center">
                <h3 class="text-lg font-semibold">Publiés</h3>
                <p class="text-2xl font-bold">{{ $stats['publies'] }}</p>
            </div>
        </div>

        {{-- Séparation --}}
        <hr class="my-8 border-gray-300">

        {{-- Prochains séminaires --}}
        <h3 class="text-xl font-bold mb-4 text-gray-700 flex items-center gap-2">
            📅 Prochains séminaires
        </h3>

        <div class="overflow-x-auto mb-8">
            <table class="min-w-full table-auto border border-collapse border-gray-300 bg-white text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left text-gray-700">
                        <th class="border px-4 py-2">Thème</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Présentateur</th>
                        <th class="border px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prochains as $s)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $s->theme }}</td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($s->date_presentation)->format('d/m/Y') }}</td>
                            <td class="border px-4 py-2">{{ $s->presentateur->name }}</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('secretaire.seminaires') }}"
                                   class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition">
                                    Gérer
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-4 py-4 text-center text-gray-500 italic">
                                Aucun séminaire validé à venir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Séparation --}}
        <hr class="my-8 border-gray-300">

        {{-- Dernières demandes --}}
        <h3 class="text-xl font-bold mb-4 text-gray-700">📝 Dernières demandes</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-collapse border-gray-300 bg-white text-sm">
                <thead>
                    <tr class="bg-yellow-100 text-left text-gray-700">
                        <th class="border px-4 py-2">Thème</th>
                        <th class="border px-4 py-2">Présentateur</th>
                        <th class="border px-4 py-2">Soumise</th>
                        <th class="border px-4 py-2">Statut</th>
                        <th class="border px-4 py-2">Motif (si rejet)</th>
                        <th class="border px-4 py-2 text-center">Valider</th>
                        <th class="border px-4 py-2 text-center">Rejeter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($demandes as $d)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $d->theme }}</td>
                            <td class="border px-4 py-2">{{ $d->presentateur->name }}</td>
                            <td class="border px-4 py-2">{{ $d->created_at->diffForHumans() }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $d->statut }}</td>
                            <td class="border px-4 py-2 text-sm text-gray-600 italic">
                                {{ $d->motif_rejet ?? '-' }}
                            </td>
                            {{-- Bouton valider --}}
                            <td class="border px-4 py-2 text-center">
                                <form action="{{ route('secretaire.demande.valider', $d) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                        ✅
                                    </button>
                                </form>
                            </td>
                            {{-- Formulaire rejeter --}}
                            <td class="border px-4 py-2 text-center">
                                <form action="{{ route('secretaire.demande.rejeter', $d) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2">
                                    @csrf
                                    <input type="text" name="motif" placeholder="Motif"
                                        class="border rounded px-2 py-1 text-sm w-full sm:w-32" required>
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                        ❌
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border px-4 py-4 text-center text-gray-500 italic">
                                Aucune demande en attente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
