@extends('layouts.app')

@section('title', 'Planning des séminaires')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📅 Planning Mensuel des Séminaires</h2>

    <div id="calendar" class="bg-white rounded shadow p-4"></div>
</div>
@endsection

@section('scripts')
<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: @json($evenements)
        });

        calendar.render();
    });
</script>
@endsection
