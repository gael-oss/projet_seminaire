{{-- resources/views/dashboards/dashboard_etudiant.blade.php --}}
@extends('layouts.app')

@section('title', 'Tableau de bord Étudiant')

@section('content')
<div class="text-white">
    {{-- Titre --}}
    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <span class="mr-2 text-2xl">🎓</span> Tableau de bord Étudiant
    </h2>

    {{-- Statistiques (optionnel) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-gray-100/50 border-l-4 border-gray-500 p-4 rounded text-gray-900">
            <p class="text-sm uppercase tracking-wide">Séminaires publiés</p>
            <p class="text-3xl font-bold">{{ $stats['publies'] }}</p>
        </div>
        <div class="bg-gray-100/50 border-l-4 border-gray-500 p-4 rounded text-gray-900">
            <p class="text-sm uppercase tracking-wide">Séminaires disponibles</p>
            <p class="text-3xl font-bold">{{ $seminaires->count() }}</p>
        </div>
    </div>

    {{-- Calendrier FullCalendar --}}
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-200 mb-3 flex items-center">
            <span class="mr-2 text-lg">🗓️</span> Calendrier des séminaires
        </h3>
        <div id="calendar" class="bg-white/20 border border-white/30 rounded-lg shadow p-4"></div>
    </div>

    {{-- Liste des séminaires publiés --}}
    <div>
        <h3 class="text-xl font-semibold text-gray-200 mb-3 flex items-center">
            <span class="mr-2 text-lg">📥</span> Séminaires disponibles
        </h3>
        @if($seminaires->isEmpty())
            <p class="italic text-gray-300">Aucun séminaire publié pour le moment.</p>
        @else
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="bg-transparent w-full table-auto border-collapse text-sm">
                    <thead class="bg-white/20 text-gray-200">
                        <tr>
                            <th class="px-4 py-2 border">Thème</th>
                            <th class="px-4 py-2 border">Présentateur</th>
                            <th class="px-4 py-2 border">Date</th>
                            <th class="px-4 py-2 border text-center">Fichier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seminaires as $s)
                            <tr class="hover:bg-white/10">
                                <td class="px-4 py-2 border">{{ $s->theme }}</td>
                                <td class="px-4 py-2 border">{{ $s->presentateur->name }}</td>
                                <td class="px-4 py-2 border">{{ $s->date_presentation->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 border text-center">
                                    @if($s->fichier_final)
                                        <a href="{{ route('etudiant.telecharger', $s) }}"
                                           class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
                                            📥 Télécharger
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Indisponible</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    {{-- FullCalendar JS --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: [
                    @foreach($seminaires as $s)
                    {
                        title: '{{ addslashes($s->theme) }}',
                        start: '{{ $s->date_presentation->format('Y-m-d') }}'
                    },
                    @endforeach
                ],
                eventColor: '#2563EB',
                height: 450
            });
            calendar.render();
        });
    </script>
@endsection
