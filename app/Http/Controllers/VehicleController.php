<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Enregistrer un nouveau véhicule.
     */
    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20',
            'color' => 'nullable|string|max:50',
            'seats_total' => 'required|integer|min:1',
        ]);

        $vehicle = new Vehicle($request->all());
        $vehicle->owner_id = auth()->id();
        $vehicle->save();

        return redirect()->back()->with('status', 'vehicle-added');
    }

    /**
     * Mettre à jour un véhicule existant.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        // Vérification de l'autorisation (seul le propriétaire peut mettre à jour)
        if ($vehicle->owner_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:20',
            'color' => 'nullable|string|max:50',
            'seats_total' => 'required|integer|min:1',
        ]);

        $vehicle->update($validated);

        return redirect()->back()->with('status', 'vehicle-updated');
    }

    /**
     * Supprimer un véhicule.
     */
    public function destroy(Vehicle $vehicle)
    {
        // Vérification de l'autorisation (seul le propriétaire peut supprimer)
        if ($vehicle->owner_id !== auth()->id()) {
            abort(403);
        }

        $vehicle->delete();

        return redirect()->back()->with('status', 'vehicle-deleted');
    }
}
