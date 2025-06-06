<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la vue de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Gère la requête de connexion.
     */
   public function store(LoginRequest $request): RedirectResponse
   {
       $request->authenticate();
       $request->session()->regenerate();
   
       $user = Auth::user();
   
       // Bloquer tous sauf le secrétaire officiel
       if ($user->role === 'secretaire' && $user->email !== 'secretaire@imsp.bj') {
           Auth::logout();
           return redirect()->route('login')->withErrors(['email' => 'Seul le secrétaire officiel peut se connecter.']);
       }
   
       // Redirection selon le rôle
       return redirect()->intended(match ($user->role) {
           'admin' => route('admin.dashboard'),
           'secretaire' => route('secretaire.dashboard'),
           'presentateur' => route('presentateur.dashboard'),
           'etudiant' => route('etudiant.dashboard'),
           default => route('dashboard'),
       });
   }
   
    /**
     * Déconnecte l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
