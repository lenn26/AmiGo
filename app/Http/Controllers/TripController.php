<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_address' => 'required|string|max:255',
            'end_address' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
            'vehicle_id' => 'required|exists:VEHICLES,id',
            'seats_available' => 'required|integer|min:1|max:8',
            'girl_only' => 'nullable',
            'accepts_pets' => 'nullable',
            'accepts_luggage' => 'nullable',
            'start_lat' => 'required|numeric',
            'start_long' => 'required|numeric',
            'end_lat' => 'required|numeric',
            'end_long' => 'required|numeric',
            'description' => 'nullable|string|max:500',
        ], [
            'start_address.required' => 'L\'adresse de départ est requise.',
            'end_address.required' => 'L\'adresse d\'arrivée est requise.',
            'date.required' => 'La date de départ est requise.',
            'date.after_or_equal' => 'La date ne peut pas être dans le passé.',
            'time.required' => 'L\'heure de départ est requise.',
            'price.required' => 'Le prix du trajet est requis.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne peut pas être négatif.',
            'vehicle_id.required' => 'Veuillez sélectionner un véhicule.',
            'vehicle_id.exists' => 'Le véhicule sélectionné est invalide.',
            'start_lat.required' => 'Veuillez sélectionner une adresse de départ dans la liste.',
            'start_long.required' => 'Veuillez sélectionner une adresse de départ dans la liste.',
            'end_lat.required' => 'Veuillez sélectionner une adresse d\'arrivée dans la liste.',
            'end_long.required' => 'Veuillez sélectionner une adresse d\'arrivée dans la liste.',
            'description.max' => 'La description ne doit pas dépasser 500 caractères.',
        ]);

        // Sécurité : Vérification contre l'IDOR
        // On vérifie que le véhicule appartient bien à l'utilisateur connecté
        $vehicleCheck = \App\Models\Vehicle::where('id', $validated['vehicle_id'])
                        ->where('owner_id', Auth::id())
                        ->exists();

        if (! $vehicleCheck) {
            throw ValidationException::withMessages([
                'vehicle_id' => ['Le véhicule sélectionné ne vous appartient pas.']
            ]);
        }

        $start_time = Carbon::parse($validated['date'] . ' ' . $validated['time']);

        if ($start_time->isPast()) {
            throw ValidationException::withMessages([
                'time' => ['L\'heure de départ est déjà passée !']
            ]);
        }

        $trip = Trip::create([
            'driver_id' => Auth::id(),
            'vehicle_id' => $validated['vehicle_id'],
            'start_address' => $validated['start_address'],
            'end_address' => $validated['end_address'],
            'start_time' => $start_time,
            // Utilisation de la durée calculée par l'API si disponible
            'end_time' => $request->has('duration') ? $start_time->copy()->addSeconds((int) $request->duration) : $start_time->copy()->addHours(1),
            'price' => $validated['price'],
            'seats_available' => $validated['seats_available'],
            'status' => 'planned',
            'girl_only' => $request->has('girl_only'),
            'accepts_pets' => $request->has('accepts_pets'),
            'accepts_luggage' => $request->has('accepts_luggage'),
            // Coordonnées validées
            'start_lat' => $validated['start_lat'],
            'start_long' => $validated['start_long'],
            'end_lat' => $validated['end_lat'],
            'end_long' => $validated['end_long'],
            'description' => $validated['description'] ?? null,
            'distance_km' => $request->has('distance') ? round($request->input('distance') / 1000, 1) : 0,
        ]);

        return redirect()->route('trips')->with('success', 'Votre trajet a été publié avec succès !');
    }
}
