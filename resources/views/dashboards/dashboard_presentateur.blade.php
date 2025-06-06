{{-- resources/views/dashboards/dashboard_presentateur.blade.php --}}
@extends('layouts.app')

@section('title','Tableau de bord du Présentateur')

@section('content')
<div class="text-white">

    {{-- titre --}}
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <span class="mr-2">🎤</span> Tableau de bord du Présentateur
    </h2>

    {{-- statistiques --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-green-100/50 border-l-4 border-green-500 p-4 rounded text-green-900">
            <p class="text-sm uppercase">Total</p>
            <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-yellow-100/50 border-l-4 border-yellow-500 p-4 rounded text-yellow-900">
            <p class="text-sm uppercase">Validés</p>
            <p class="text-3xl font-bold">{{ $stats['valides'] }}</p>
        </div>
        <div class="bg-blue-100/50 border-l-4 border-blue-500 p-4 rounded text-blue-900">
            <p class="text-sm uppercase">Publiés</p>
            <p class="text-3xl font-bold">{{ $stats['publies'] }}</p>
        </div>
    </div>

    {{-- notifications --}}
    @if($notifications->isNotEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 mb-6 rounded">
            <h3 class="font-semibold mb-2">🔔 Notifications</h3>
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach($notifications as $note)
                    <li>
                        {{ $note->data['message'] ?? 'Nouvelle notification' }}
                        <span class="text-xs text-gray-500">— {{ $note->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- calendrier --}}
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-200 mb-3 flex items-center">
            <span class="mr-2">🗓️</span> Calendrier des séminaires
        </h3>
        <div id="calendar" class="bg-white/20 border border-white/30 rounded-lg shadow p-4"></div>
    </div>

    {{-- prochains séminaires --}}
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
            <span class="mr-2">📌</span> Prochains séminaires
        </h3>
        @if($prochains->isEmpty())
            <p class="italic text-gray-300">Aucun séminaire à venir.</p>
        @else
            <ul class="space-y-2">
                @foreach($prochains as $s)
                    <li class="bg-white/10 hover:bg-white/20 border-l-4 border-indigo-500 p-3 rounded shadow-sm">
                        <span class="font-semibold">{{ $s->theme }}</span> —
                        <span class="text-sm text-gray-300">{{ $s->date_presentation->format('d/m/Y') }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- derniers séminaires --}}
    <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
        <span class="mr-2">📋</span> Vos 5 derniers séminaires
    </h3>
    @if($seminaires->isEmpty())
        <p class="italic text-gray-300">Vous n’avez encore soumis aucun séminaire.</p>
    @else
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full table-auto bg-transparent border-collapse text-sm">
                <thead class="bg-white/20 text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">Thème</th>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Statut</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seminaires as $s)
                        @php $limite = $s->date_presentation->copy()->subDays(10); @endphp
                        <tr class="hover:bg-white/10">
                            <td class="px-4 py-2 border">{{ $s->theme }}</td>
                            <td class="px-4 py-2 border">{{ $s->date_presentation->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 border capitalize">{{ $s->statut }}</td>
                            <td class="px-4 py-2 border text-center">
                                @if($s->statut==='validé' && now()->gte($limite))
                                    <a href="{{ route('seminaires.editResume',$s) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-xs">
                                        ✍️ Résumé
                                    </a>
                                @elseif($s->statut==='publié' && now()->isAfter($s->date_presentation))
                                    <a href="{{ route('seminaires.uploadFichier',$s) }}" class="text-green-200 hover:text-green-400 text-xs">
                                        Fichier final
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- bouton nouveau séminaire --}}
    <div class="mt-8">
        <a href="{{ route('seminaires.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            ➕ Proposer un nouveau séminaire
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView:'dayGridMonth',
        locale:'fr',
        headerToolbar:{left:'prev,next today',center:'title',right:'dayGridMonth,timeGridWeek'},
        events:[
            @foreach($prochains as $s)
                {title:@json($s->theme),start:'{{ $s->date_presentation->format('Y-m-d') }}'},
            @endforeach
        ],
        eventColor:'#4F46E5',
        height:500
    });
    calendar.render();
});
</script>
@endsection
