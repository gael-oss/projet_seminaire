<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛠️ Tableau de bord Administrateur
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <p class="text-gray-700 dark:text-gray-200 text-lg">Bienvenue, administrateur.</p>

                <div class="mt-6 space-y-4">
                    <a href="{{ route('admin.users.index') }}" class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        👥 Gérer les utilisateurs
                    </a>

                    <a href="{{ route('profile.edit') }}" class="block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        ⚙️ Modifier mon profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
