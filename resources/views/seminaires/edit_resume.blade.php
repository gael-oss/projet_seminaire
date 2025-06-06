@extends('layouts.app')

@section('title', 'Soumettre ou modifier le résumé')

@section('content')
<div class="max-w-3xl mx-auto text-white">

    <h2 class="text-2xl font-bold mb-6 flex items-center">
        <span class="mr-2">✍️</span> Soumettre / modifier le résumé
    </h2>

    {{-- Rappel du séminaire --}}
    <div class="mb-6 bg-white/10 p-4 rounded">
        <p><strong>Thème :</strong> {{ $seminaire->theme }}</p>
        <p><strong>Date&nbsp;:</strong> {{ $seminaire->date_presentation->format('d/m/Y') }}</p>
    </div>

    {{-- FORMULAIRE PUT --}}
    <form method="POST" action="{{ route('seminaires.updateResume', $seminaire) }}">
        @csrf
        @method('PUT')

        <label for="resume" class="block font-semibold mb-2">
            Résumé (≥ 20 caractères)
        </label>

        <textarea id="resume" name="resume" rows="8" required
                  class="w-full bg-transparent border border-white/30 rounded p-3 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-400">
{{ old('resume', $seminaire->resume) }}</textarea>

        @error('resume')
            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
        @enderror

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('presentateur.dashboard') }}" class="btn">Annuler</a>

            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded text-white font-semibold">
                💾 Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
