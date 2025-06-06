<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tableau de bord administrateur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-lg text-gray-900 dark:text-white mb-4">Bienvenue, {{ Auth::user()->name }}.</p>

                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">👥 Gérer les utilisateurs</a>
                    </li>
                    <li>
                        <a href="{{ route('seminaires.index') }}" class="text-blue-600 hover:underline">📄 Voir tous les séminaires</a>
                    </li>
                    <li>
                        <a href="{{ route('profil.edit') }}" class="text-blue-600 hover:underline">⚙️ Modifier mon profil</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
