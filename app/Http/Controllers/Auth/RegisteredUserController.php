<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la demande d'inscription.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:admin,secretaire,presentateur,etudiant'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Un seul secrétaire autorisé
        if ($request->role === 'secretaire' && $request->email !== 'secretaire@imsp.bj') {
            return back()->withErrors([
                'email' => 'Seul l’email officiel secretaire@imsp.bj peut être utilisé pour ce rôle.',
            ])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect($this->redirectTo($user));
    }

    /**
     * Redirige vers le bon dashboard après inscription.
     */
    protected function redirectTo($user)
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'secretaire' => route('secretaire.dashboard'),
            'presentateur' => route('presentateur.dashboard'),
            'etudiant' => route('etudiant.dashboard'),
            default => route('dashboard'),
        };
    }
}
