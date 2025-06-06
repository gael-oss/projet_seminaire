@extends('layouts.app')

@section('content')
<div class="container">
    <h1>📥 Soumissions de séminaires</h1>

    @if ($seminaires->isEmpty())
        <p>Aucun séminaire en attente de validation.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Thème</th>
                    <th>Contenu</th>
                    <th>Date proposée</th>
                    <th>Présentateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seminaires as $seminaire)
                    <tr>
                        <td>{{ $seminaire->theme }}</td>
                        <td>{{ $seminaire->contenu }}</td>
                        <td>{{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</td>
                        <td>{{ $seminaire->presentateur->name }}</td>
                        <td>
                            <form action="{{ route('secretaire.valider', $seminaire->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">✅ Valider</button>
                            </form>

                            <form action="{{ route('secretaire.rejeter', $seminaire->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">❌ Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
