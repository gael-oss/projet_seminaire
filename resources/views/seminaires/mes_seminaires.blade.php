@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mes séminaires</h1>

    <!-- Message de confirmation -->
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Thème</th>
                <th>Date</th>
                <th>Résumé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($seminaires as $seminaire)
            <tr>
                <td>{{ $seminaire->theme }}</td>
                <td>{{ \Carbon\Carbon::parse($seminaire->date_presentation)->format('d/m/Y') }}</td>
                <td>{{ $seminaire->resume ? \Illuminate\Support\Str::limit($seminaire->resume, 50) : 'Non soumis' }}</td>
                <td>
                    <!-- Formulaire de soumission de résumé (si statut valide) -->
                    @if($seminaire->statut === 'valide')
                        <form action="{{ route('seminaires.updateResume', $seminaire->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="resume" rows="2" cols="30" required>{{ $seminaire->resume }}</textarea><br>
                            <button type="submit">Soumettre le résumé</button>
                        </form>
                    @endif

                    <!-- Formulaire d'upload de fichier (si statut publié) -->
                    @if($seminaire->statut === 'publie')
                        <form action="{{ route('seminaires.uploadFichier', $seminaire->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="fichier" accept="application/pdf" required><br>
                            <button type="submit">Uploader la présentation</button>
                        </form>

                        <!-- Lien de téléchargement si fichier déjà téléversé -->
                        @if($seminaire->fichier)
                            <div class="mt-2">
                                <a href="{{ asset('storage/presentations/' . $seminaire->fichier) }}" target="_blank">
                                    📥 Télécharger la présentation
                                </a>
                            </div>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
