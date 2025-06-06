<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Menu Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Liens de Navigation -->
                @auth
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        @if(auth()->user()->role === 'secretaire')
                            <x-nav-link :href="route('secretaire.dashboard')" :active="request()->routeIs('secretaire.dashboard')">📊 Dashboard Secrétaire</x-nav-link>
                        @elseif(auth()->user()->role === 'presentateur')
                            <x-nav-link :href="route('presentateur.dashboard')" :active="request()->routeIs('presentateur.dashboard')">🎤 Dashboard Présentateur</x-nav-link>
                            <x-nav-link :href="route('seminaires.create')" :active="request()->routeIs('seminaires.create')">➕ Soumettre</x-nav-link>
                            <x-nav-link :href="route('seminaires.mes')" :active="request()->routeIs('seminaires.mes')">📝 Mes Séminaires</x-nav-link>
                        @elseif(auth()->user()->role === 'etudiant')
                            <x-nav-link :href="route('etudiant.dashboard')" :active="request()->routeIs('etudiant.dashboard')">🎓 Dashboard Étudiant</x-nav-link>
                        @elseif(auth()->user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">⚙️ Dashboard Admin</x-nav-link>
                        @endif
                        <x-nav-link :href="route('seminaires.public')" :active="request()->routeIs('seminaires.public')">📖 Séminaires Publiés</x-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Dropdown Profil -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Lien profil -->
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 Profil
                        </x-dropdown-link>

                        <!-- Déconnexion -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                🔓 Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger Responsive -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:text-gray-500 dark:hover:text-gray-400 dark:hover:bg-gray-900">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Responsive -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        @auth
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role === 'secretaire')
                <x-responsive-nav-link :href="route('secretaire.dashboard')" :active="request()->routeIs('secretaire.dashboard')">📊 Dashboard Secrétaire</x-responsive-nav-link>
            @elseif(auth()->user()->role === 'presentateur')
                <x-responsive-nav-link :href="route('presentateur.dashboard')" :active="request()->routeIs('presentateur.dashboard')">🎤 Dashboard Présentateur</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seminaires.create')" :active="request()->routeIs('seminaires.create')">➕ Soumettre</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seminaires.mes')" :active="request()->routeIs('seminaires.mes')">📝 Mes Séminaires</x-responsive-nav-link>
            @elseif(auth()->user()->role === 'etudiant')
                <x-responsive-nav-link :href="route('etudiant.dashboard')" :active="request()->routeIs('etudiant.dashboard')">🎓 Dashboard Étudiant</x-responsive-nav-link>
            @elseif(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">⚙️ Dashboard Admin</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('seminaires.public')" :active="request()->routeIs('seminaires.public')">📖 Séminaires Publiés</x-responsive-nav-link>
        </div>

        <!-- Info utilisateur + déconnexion -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 Profil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        🔓 Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
