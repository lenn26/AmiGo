<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Affiche le formulaire d'inscription.
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère une nouvelle demande d'enregistrement utilisateur.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // Vérification automatique si l'email est d'une université d'Amiens
        $universityDomains = [
            '@u-picardie.fr',
            '@etud.u-picardie.fr',
            '@u-picardie.com',
            '@univ-picardie.fr'
        ];
        
        $isVerified = false;
        foreach ($universityDomains as $domain) {
            if (str_ends_with($request->email, $domain)) {
                $isVerified = true;
                break;
            }
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_verified' => $isVerified,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirection vers la page d'accueil après l'inscription
        return redirect(route('home', absolute: false));
    }
}
