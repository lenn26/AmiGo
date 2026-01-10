<?php

use App\Http\Controllers\ProfileController;
use App\Models\University;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Ce fichier enregistre les routes web de votre application.
|
*/

// --- Page d'accueil ---
Route::get('/', function () {
    return view('index');
})->name('home');

// API pour la recherche d'universités (autocomplétion)
Route::get('/api/locations', [App\Http\Controllers\UniversityController::class, 'search'])->name('api.universities.search');

use Illuminate\Http\Request;
use App\Models\Trip;

// Page de recherche de trajets
Route::get('/trajets', function (Request $request) {
    // On ne veut que les trajets futurs et non terminés
    // Donc on filtre sur la date de début et le statut du trajet
    $query = Trip::with('driver')
                ->where('status', '!=', 'completed')
                ->where('start_time', '>=', now());

    if ($request->filled('from')) {
        // Recherche par mots-clés pour le départ
        $keywords = array_filter(explode(' ', $request->from), fn($w) => strlen($w) > 2);
        if (empty($keywords)) {
             $query->where('start_address', 'like', '%' . $request->from . '%');
        } else {
             $query->where(function($q) use ($keywords) {
                 foreach ($keywords as $word) {
                     $q->where('start_address', 'like', '%' . $word . '%');
                 }
             });
        }
    }
    if ($request->filled('to')) {
        // Recherche par mots-clés pour l'arrivée
        $keywords = array_filter(explode(' ', $request->to), fn($w) => strlen($w) > 2);
        if (empty($keywords)) {
             $query->where('end_address', 'like', '%' . $request->to . '%');
        } else {
             $query->where(function($q) use ($keywords) {
                 foreach ($keywords as $word) {
                     $q->where('end_address', 'like', '%' . $word . '%');
                 }
             });
        }
    }
    if ($request->filled('date')) {
        $query->whereDate('start_time', $request->date);
    }
    if ($request->filled('seats')) {
        $query->where('seats_available', '>=', $request->seats);
    }
    
    // Filtres des options
    if ($request->boolean('luggage')) {
        $query->where('accepts_luggage', true);
    }
    if ($request->boolean('pets')) {
        $query->where('accepts_pets', true);
    }
    if ($request->boolean('girl_only')) {
        $query->where('girl_only', true);
    }

    $trips = $query->get();
    return view('trips', compact('trips'));
})->name('trips');

use App\Models\Vehicle;
use App\Http\Controllers\TripController;

// Proposition de trajet
// Affichage du formulaire de proposition
Route::middleware('auth')->get('/proposer-trajet', function () {
    // Récupération des trajets du conducteur pour l'historique rapide à droite
    $userTrips = Trip::where('driver_id', auth()->id())
                    ->orderBy('start_time', 'asc')
                    ->get();
    // Récupération des véhicules de l'utilisateur
    $vehicles = Vehicle::where('owner_id', auth()->id())->get();
    return view('propose', compact('userTrips', 'vehicles'));
})->name('trips.create');

// Enregistrement d'un nouveau trajet
Route::post('/proposer-trajet', [TripController::class, 'store'])->name('trips.store')->middleware('auth');

// Tableau de bord utilisateur
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\VehicleController;

Route::middleware('auth')->group(function () {
    // Gestion des véhicules 
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::patch('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
    
    // Page "Mes réservations" 
    Route::get('/mes-reservations', function () {
        $bookings = App\Models\Booking::with(['trip.driver', 'trip.vehicle'])
            ->where('passenger_id', auth()->id())
            ->get()
            ->sortByDesc(fn($booking) => $booking->trip->start_time);

        $upcoming = $bookings->filter(fn($b) => $b->trip->start_time >= now());
        $history = $bookings->filter(fn($b) => $b->trip->start_time < now());

        return view('reservations', compact('upcoming', 'history'));
    })->name('reservations');

    // API Interne : Récupération AJAX des véhicules
    Route::get('/api/user/vehicles', function () {
        return auth()->user()->vehicles()->get(['id', 'make', 'model', 'license_plate']);
    })->name('api.user.vehicles');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Espace Administration
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/trips', [App\Http\Controllers\AdminController::class, 'trips'])->name('admin.trips');
    Route::delete('/admin/trips/{trip}', [App\Http\Controllers\AdminController::class, 'deleteTrip'])->name('admin.trips.delete');
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/campus', [App\Http\Controllers\AdminController::class, 'campus'])->name('admin.campus');
    Route::post('/admin/campus', [App\Http\Controllers\AdminController::class, 'storeCampus'])->name('admin.campus.store');
    Route::delete('/admin/campus/{university}', [App\Http\Controllers\AdminController::class, 'deleteCampus'])->name('admin.campus.delete');
    Route::get('/admin/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
    Route::patch('/admin/reports/{report}', [App\Http\Controllers\AdminController::class, 'updateReport'])->name('admin.reports.update');
});

// Pages statiques & Légales
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/legal/notice', function () {
    return view('legal.notice');
})->name('legal.notice');

Route::get('/legal/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');

Route::get('/legal/terms', function () {
    return view('legal.terms');
})->name('legal.terms');

require __DIR__ . '/auth.php';
