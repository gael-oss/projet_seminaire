@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📅 Planning des séminaires ({{ now()->format('F Y') }})</h1>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Date</th>
                <th>Thème</th>
                <th>Présentateur</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seminaires as $s)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($s->date_presentation)->format('d/m/Y') }}</td>
                    <td>{{ $s->theme }}</td>
                    <td>{{ $s->presentateur->name }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Aucun séminaire prévu ce mois-ci.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
