@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('title', 'Séminaires publiés')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg">

        <h2 class="text-3xl font-bold text-gray-800 mb-6">📚 Séminaires publiés</h2>

        @if($seminaires->isEmpty())
            <p class="text-gray-500 italic">Aucun séminaire publié pour l’instant.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-collapse border-gray-300 bg-white text-sm">
                    <thead class="bg-gray-100 text-left text-gray-700">
                        <tr>
                            <th class="border px-4 py-2">Thème</th>
                            <th class="border px-4 py-2">Présentateur</th>
                            <th class="border px-4 py-2">Date</th>
                            <th class="border px-4 py-2">Résumé</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seminaires as $s)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $s->theme }}</td>
                                <td class="border px-4 py-2">{{ $s->presentateur->name }}</td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($s->date_presentation)->format('d/m/Y') }}</td>
                                <td class="border px-4 py-2 text-gray-700">{!! nl2br(e(Str::limit($s->resume, 150))) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $seminaires->links() }}
                </div>                
            </div>
        @endif

    </div>
</div>
@endsection
