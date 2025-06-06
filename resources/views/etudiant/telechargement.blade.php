@extends('layouts.app')

@section('title', 'Téléchargement')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-xl font-bold mb-6 text-gray-700">📥 Présentations disponibles</h2>

    <table class="min-w-full table-auto border border-gray-300 text-sm bg-white">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">Thème</th>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Résumé</th>
                <th class="border px-4 py-2">Télécharger</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seminaires as $s)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $s->theme }}</td>
                    <td class="border px-4 py-2">{{ $s->date_presentation->format('d/m/Y') }}</td>
                    <td class="border px-4 py-2">{{ \Illuminate\Support\Str::limit($s->resume, 60) }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('etudiant.telecharger', $s) }}"
                           class="text-blue-600 hover:underline">📎 Télécharger</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
