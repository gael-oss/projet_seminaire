@extends('layouts.app')

@section('content')
<div class="container max-w-2xl mx-auto">
    <h1 class="text-xl font-bold mb-6">📢 Soumettre un nouveau séminaire</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('presentateur.seminaires.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="titre" class="block font-medium">Titre du séminaire</label>
            <input type="text" name="titre" id="titre" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="contenu" class="block font-medium">Contenu</label>
            <textarea name="contenu" id="contenu" rows="5" class="w-full border px-3 py-2 rounded" required></textarea>
        </div>

        <div class="mb-4">
            <label for="date_presentation" class="block font-medium">Date de présentation</label>
            <input type="date" name="date_presentation" id="date_presentation" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Soumettre
        </button>
    </form>
</div>
@endsection
