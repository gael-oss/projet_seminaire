{{-- resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion – IMSP</title>

    {{-- Boxicons pour les icônes --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- 1) IMPORT du CSS principal partagé (app.css) qui contient le background --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- 2) (optionnel) CSS spécifique au formulaire de login --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="wrapper mx-auto max-w-md mt-16">
        <form method="POST" action="{{ route('login') }}" class="p-6">
            @csrf

            <h1 class="text-2xl font-semibold mb-6 text-white text-center">Connexion</h1>

            <div class="input-box mb-4 relative">
                <input type="email" name="email" placeholder="Adresse email" required autofocus
                       class="w-full px-3 py-2 border rounded bg-transparent placeholder-gray-300 text-white focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <i class='bx bxs-user absolute right-3 top-3 text-gray-300'></i>
            </div>

            <div class="input-box mb-4 relative">
                <input type="password" name="password" placeholder="Mot de passe" required
                       class="w-full px-3 py-2 border rounded bg-transparent placeholder-gray-300 text-white focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <i class='bx bxs-lock-alt absolute right-3 top-3 text-gray-300'></i>
            </div>

            <div class="remember-forgot flex justify-between items-center mb-6 text-sm">
                <label class="flex items-center space-x-2 text-white">
                    <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 rounded">
                    <span>Se souvenir de moi</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-indigo-200 hover:underline">Mot de passe oublié ?</a>
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition mb-4">
                Se connecter
            </button>

            <div class="register-link text-center text-white">
                <p>Pas de compte ? <a href="{{ route('register') }}" class="text-indigo-200 hover:underline">Inscription</a></p>
            </div>
        </form>
    </div>
</body>
</html>
q
