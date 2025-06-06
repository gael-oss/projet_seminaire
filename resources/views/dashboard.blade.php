<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow text-gray-900 dark:text-gray-100">

            <p><strong>Bienvenue :</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
            <p><strong>Rôle :</strong> {{ Auth::user()->role }}</p>

            @php $role = Auth::user()->role; @endphp

            @if ($role === 'admin')
                <p>✅ Ceci est le tableau de bord de l’administrateur.</p>
            @elseif ($role === 'secretaire')
                <p>✅ Ceci est le tableau de bord du secrétaire.</p>
            @elseif ($role === 'presentateur')
                <p>✅ Ceci est le tableau de bord du présentateur.</p>
            @elseif ($role === 'etudiant')
                <p>✅ Ceci est le tableau de bord de l’étudiant.</p>
            @else
                <p>❌ Rôle non reconnu.</p>
            @endif

        </div>
    </div>
</x-app-layout>
