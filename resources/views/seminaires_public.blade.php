@extends('layouts.app')

@section('title', 'Séminaires Publiés')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">📚 Séminaires Publiés</h2>

    @if($seminaires->isEmpty())
        <p class="text-gray-500 italic">Aucun séminaire n'a encore été publié.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full border border-collapse border-gray-300 bg-white text-sm">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-700">
                    <th class="border px-4 py-2">Thème</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Résumé</th>
                    <th class="border px-4 py-2">Présentateur</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seminaires as $s)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $s->theme }}</td>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($s->date_presentation)->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2">{{ $s->resume }}</td>
                        <td class="border px-4 py-2">{{ $s->presentateur->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
