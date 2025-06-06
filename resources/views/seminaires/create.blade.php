@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-bold mb-4">Demander un séminaire</h2>

        <form method="POST" action="{{ route('seminaires.store') }}">
            @csrf

            <div class="mb-4">
                <label for="theme" class="block font-medium">Thème</label>
                <input type="text" name="theme" id="theme" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="date_presentation" class="block font-medium">Période souhaitée</label>
                <input type="date" name="date_presentation" id="date_presentation" required class="w-full border rounded px-3 py-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Envoyer la demande
            </button>
        </form>
    </div>
</div>
@endsection
