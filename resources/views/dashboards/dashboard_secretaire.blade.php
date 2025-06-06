{{-- resources/views/dashboards/dashboard_secretaire.blade.php --}}
@extends('layouts.app')

@section('title', 'Tableau de bord du Secrétaire')

@section('content')
<div class="text-white">
    {{-- Titre --}}
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <span class="mr-2 text-2xl">📊</span> Tableau de bord du Secrétaire
    </h2>

    {{-- Statistiques --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-yellow-100/50 border-l-4 border-yellow-500 p-4 rounded text-yellow-900">
            <p class="text-sm uppercase tracking-wide">Total séminaires</p>
            <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-green-100/50 border-l-4 border-green-500 p-4 rounded text-green-900">
            <p class="text-sm uppercase tracking-wide">Validés</p>
            <p class="text-3xl font-bold">{{ $stats['valides'] }}</p>
        </div>
        <div class="bg-blue-100/50 border-l-4 border-blue-500 p-4 rounded text-blue-900">
            <p class="text-sm uppercase tracking-wide">Publiés</p>
            <p class="text-3xl font-bold">{{ $stats['publies'] }}</p>
        </div>
    </div>

    {{-- Prochains séminaires --}}
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-3 flex items-center">
            <span class="mr-2 text-lg">📅</span> Prochains séminaires
        </h3>

        <table class="bg-transparent w-full table-auto border-collapse text-sm">
            <thead class="bg-white/20 text-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Thème</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Présentateur</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            {{-- … haut du fichier inchangé … --}}
          <tbody>
          @forelse($prochains as $s)
              <tr class="hover:bg-white/10">
                  <td class="px-4 py-2 border">{{ $s->theme }}</td>
                  <td class="px-4 py-2 border">{{ $s->date_presentation->format('d/m/Y') }}</td>
                  <td class="px-4 py-2 border">{{ $s->presentateur->name }}</td>
                  <td class="px-4 py-2 border text-center">
                      <a href="{{ route('secretaire.seminaires.show',$s) }}"
                         class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">
                          Gérer
                      </a>
                  </td>
              </tr>
          @empty
              <tr><td colspan="4" class="py-4 text-center text-gray-300 italic">Aucun.</td></tr>
          @endforelse
          </tbody>
        </table>
    </div>

   {{-- === Dernières demandes === --}}
   @forelse($demandes as $s)
       <div class="mb-4 p-4 bg-white/20 border border-white/30 rounded">
           <p class="font-semibold">{{ $s->theme }}</p>
           <p class="text-sm text-gray-300">
               Par : {{ $s->presentateur->name }} — demandé {{ $s->created_at->diffForHumans() }}
           </p>
   
           <div class="mt-3 flex items-center space-x-2">
               {{-- Valider --}}
               <form action="{{ route('secretaire.demandes.valider', $s) }}" method="POST">
                   @csrf
                   <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs flex items-center">
                       ✔️ <span class="ml-1">Valider</span>
                   </button>
               </form>
   
               {{-- Rejeter --}}
               <form action="{{ route('secretaire.demandes.reject', $s) }}" method="POST" class="flex items-center space-x-1">
                   @csrf
                   <input type="text" name="motif" required placeholder="Motif"
                          class="bg-transparent border border-red-300 rounded px-2 py-1 text-xs text-white placeholder-gray-300">
                   <button class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs flex items-center">
                       ❌ <span class="ml-1">Rejeter</span>
                   </button>
               </form>
           </div>
       </div>
   @empty
       <p class="text-gray-300 italic">Aucune demande récente.</p>
   @endforelse
    </div>
@endsection
