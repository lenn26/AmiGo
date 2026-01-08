<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_address' => 'required|string|max:255',
            'end_address' => 'required|string|max:255',
            'date' => 'required|date',
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
        ], [
            'start_lat.required' => 'Veuillez sélectionner une adresse de départ dans la liste.',
            'end_lat.required' => 'Veuillez sélectionner une adresse d\'arrivée dans la liste.',
        ]);

        $start_time = Carbon::parse($validated['date'] . ' ' . $validated['time']);

        // Pour l'instant, nous utilisons des valeurs par défaut pour les coordonnées
        // Dans une version plus avancée, il faudrait utiliser une API de géocodage
        $trip = Trip::create([
            'driver_id' => Auth::id(),
            'vehicle_id' => $validated['vehicle_id'],
            'start_address' => $validated['start_address'],
            'end_address' => $validated['end_address'],
            'start_time' => $start_time,
            // Estimation basique ou null pour l'instant
            'end_time' => $start_time->copy()->addHours(1), 
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
            'distance_km' => 0,
            'description' => null,
        ]);

        return redirect()->route('trips')->with('success', 'Votre trajet a été publié avec succès !');
    }
}
