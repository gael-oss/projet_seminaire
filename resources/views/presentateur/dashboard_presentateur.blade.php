<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🎤 Tableau de bord du présentateur
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Mes séminaires soumis</h3>

                @if ($seminaires->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">Aucun séminaire soumis pour le moment.</p>
                @else
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead class="text-xs uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2">Titre</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($seminaires as $seminaire)
                                <tr class="border-b border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $seminaire->titre }}</td>
                                    <td class="px-4 py-2">{{ $seminaire->date_presentation }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($seminaire->statut) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <div class="mt-6">
                    <a href="{{ route('seminaires.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        ➕ Soumettre un séminaire
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
