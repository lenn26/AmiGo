<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $vehicle = $request->user()->vehicles()->first() 
                   ?? new \App\Models\Vehicle;

        return view('profile.edit', [
            'user' => $request->user(),
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Gestion du véhicule
        // On vérifie si au moins un champ véhicule est rempli pour créer/mettre à jour
        if ($request->filled(['make', 'model', 'color', 'license_plate', 'seats_total'])) {
             $vehicle = $request->user()->vehicles()->first();
             
             if (!$vehicle) {
                $vehicle = new \App\Models\Vehicle();
                $vehicle->owner_id = $request->user()->id;
             }
             
             $vehicle->make = $request->validated('make') ?? 'Unknown';
             $vehicle->model = $request->validated('model');
             $vehicle->color = $request->validated('color');
             $vehicle->license_plate = $request->validated('license_plate');
             $vehicle->seats_total = $request->validated('seats_total');
             
             $vehicle->save();
        }

        if ($request->filled('password')) {
             $request->validate([
                'password' => ['confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            ]);
            
            $request->user()->update([
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
