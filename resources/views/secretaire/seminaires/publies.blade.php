@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📚 Séminaires publiés</h1>

        @if($seminaires->isEmpty())
            <p class="text-gray-600">Aucun séminaire publié pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Thème</th>
                            <th class="px-4 py-2 border">Date</th>
                            <th class="px-4 py-2 border">Présentateur</th>
                            <th class="px-4 py-2 border">Résumé</th>
                            <th class="px-4 py-2 border">Fichier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seminaires as $seminaire)
                            <tr class="text-center hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $seminaire->theme }}</td>
                                <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 border">{{ $seminaire->presentateur->name }}</td>
                                <td class="px-4 py-2 border text-left max-w-md">
                                    <div class="overflow-auto max-h-32 bg-gray-50 p-2 rounded">
                                        {!! nl2br(e($seminaire->resume)) !!}
                                    </div>
                                </td>
                                <td class="px-4 py-2 border">
                                    @if($seminaire->fichier_path)
                                        <a href="{{ route('seminaires.telecharger', $seminaire) }}" class="text-blue-600 hover:underline">Télécharger</a>
                                    @else
                                        <span class="text-gray-400">Non disponible</span>
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
