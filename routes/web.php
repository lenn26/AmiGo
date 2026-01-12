<?php

use App\Http\Controllers\ProfileController;
use App\Models\University;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Web
|--------------------------------------------------------------------------
|
| Ce fichier enregistre les routes web de l'application.
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
    $query = Trip::with(['driver', 'vehicle'])
                ->where('status', '!=', 'completed')
                ->where('seats_available', '>', 0)
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

    $trips = $query->orderBy('start_time', 'asc')->get();

    $upcoming_bookings = collect();
    if (auth()->check()) {
        $upcoming_bookings = auth()->user()->bookings()
            ->with('trip')
            ->whereHas('trip', function($q) {
                $q->where('start_time', '>=', now());
            })
            ->whereIn('status', ['accepted', 'confirmed', 'pending'])
            ->get()
            ->sortBy('trip.start_time');
    }

    return view('trips', compact('trips', 'upcoming_bookings'));
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

// Réservation d'un trajet
Route::post('/trips/{trip}/book', function (Request $request, Trip $trip) {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $seats = (int) $request->input('seats', 1);

    if ($seats < 1 || $seats > $trip->seats_available) {
        return back()->with('error', 'Nombre de places invalide ou insuffisant.');
    }
    if ($trip->driver_id === auth()->id()) {
        return back()->with('error', 'Vous ne pouvez pas réserver votre propre trajet.');
    }
    
    // Créer la réservation
    App\Models\Booking::create([
        'trip_id' => $trip->id,
        'passenger_id' => auth()->id(),
        'seats_booked' => $seats,
        'status' => 'confirmed' 
    ]);

    // Décrémenter les places
    $trip->decrement('seats_available', $seats);

    return redirect()->route('reservations')->with('success', 'Trajet réservé !');
})->name('trips.book')->middleware('auth');

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
    // Suppression d'un trajet par le conducteur
    Route::delete('/trajets/{trip}', function (App\Models\Trip $trip) {
        // On vérifie que c'est bien mon trajet
        if ($trip->driver_id !== auth()->id()) {
            abort(403, 'Action non autorisée');
        }
        $trip->delete(); 
        return back(); 
    })->name('trips.destroy');
    
    // Page "Mes réservations" 
    Route::get('/mes-reservations', function () {
        $bookings = App\Models\Booking::with(['trip.driver', 'trip.vehicle', 'trip.reports', 'trip.bookings.passenger'])
            ->where('passenger_id', auth()->id())
            ->get()
            ->sortByDesc(fn($booking) => $booking->trip->start_time);

        // Filtrer les réservations futures et non terminées
        $upcoming = $bookings->filter(fn($b) => $b->trip->start_time >= now() && $b->trip->status !== 'completed');
        $history = $bookings->filter(fn($b) => $b->trip->start_time < now() || $b->trip->status === 'completed');

        return view('reservations', compact('upcoming', 'history'));
    })->name('reservations');

    // Annulation d'une réservation par le passager
    Route::delete('/reservations/{booking}', function (App\Models\Booking $booking) {
        if ($booking->passenger_id !== auth()->id()) {
            abort(403, 'Action non autorisée');
        }

        // Remettre les places disponibles
        $booking->trip->increment('seats_available', $booking->seats_booked);

        $booking->delete();
        return back();
    })->name('bookings.destroy');

    // Signalement d'un trajet
    Route::post('/reservations/{booking}/report', function (Request $request, App\Models\Booking $booking) {
        if ($booking->passenger_id !== auth()->id()) {
            abort(403, 'Action non autorisée');
        }

        $reportedUserId = $request->input('reported_user_id');

        // Vérification de sécurité : l'utilisateur signalé doit faire partie du trajet (Chauffeur ou Passager)
        $isDriver = $booking->trip->driver_id == $reportedUserId;
        $isPassenger = $booking->trip->bookings()->where('passenger_id', $reportedUserId)->exists();

        if (!$isDriver && !$isPassenger) {
            return back()->with('error', 'L\'utilisateur signalé ne fait pas partie de ce trajet.');
        }

        // Vérification si déjà signalé (Spécifique à la personne visée)
        if (App\Models\Report::where('trip_id', $booking->trip_id)
            ->where('reporter_id', auth()->id())
            ->where('reported_user_id', $reportedUserId)
            ->exists()) {
             return back()->with('error', 'Vous avez déjà signalé cet utilisateur pour ce trajet.');
        }

        $tripStartTime = \Carbon\Carbon::parse($booking->trip->start_time);
        
        // Vérification des 24h après le départ
        if (now()->diffInHours($tripStartTime, false) < -24) {
             return back()->with('error', 'Le délai de 24h pour signaler ce trajet est dépassé.');
        }

        // Création du signalement
        App\Models\Report::create([
            'reason' => $request->input('reason'),
            'description' => $request->input('description'),
            'status' => 'open',
            'trip_id' => $booking->trip_id,
            'reported_user_id' => $reportedUserId,
            'reporter_id' => auth()->id(),
        ]);

        return back()->with('success', 'Votre signalement a été pris en compte.');

    })->name('bookings.report');

    // Notation d'un trajet (Avis au conducteur)
    Route::post('/reservations/{booking}/rate', function (Request $request, App\Models\Booking $booking) {
        if ($booking->passenger_id !== auth()->id()) {
            abort(403, 'Action non autorisée');
        }

        // Validation
        $request->validate([
            'rating' => 'required|numeric|min:0.5|max:5', // Permet 0.5, 1, 1.5 etc
            'comment' => 'nullable|string|max:1000',
        ]);

        // Vérification si déjà noté
        if (App\Models\Rating::where('trip_id', $booking->trip_id)
            ->where('rater_id', auth()->id())
            ->exists()) {
             return back()->with('error', 'Vous avez déjà donné votre avis sur ce trajet.');
        }

        // Création de la note
        App\Models\Rating::create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'trip_id' => $booking->trip_id,
            'rated_id' => $booking->trip->driver_id,
            'rater_id' => auth()->id(),
        ]);

        return back()->with('success', 'Votre avis a été publié.');

    })->name('bookings.rate');
    
    // Signalement d'un passager par le conducteur
    Route::post('/trips/{trip}/report', function (Request $request, App\Models\Trip $trip) {
        if ($trip->driver_id !== auth()->id()) {
            abort(403, 'Action non autorisée');
        }

        $reportedUserId = $request->input('reported_user_id');

        // Vérification de sécurité : l'utilisateur signalé doit être un passager du trajet
        $isPassenger = $trip->bookings()->where('passenger_id', $reportedUserId)->exists();

        if (!$isPassenger) {
            return back()->with('error', 'L\'utilisateur signalé ne fait pas partie de ce trajet.');
        }

        // Vérification si déjà signalé
        if (App\Models\Report::where('trip_id', $trip->id)
            ->where('reporter_id', auth()->id())
            ->where('reported_user_id', $reportedUserId)
            ->exists()) {
             return back()->with('error', 'Vous avez déjà signalé cet utilisateur pour ce trajet.');
        }

        $tripStartTime = \Carbon\Carbon::parse($trip->start_time);
        
        // Vérification des 24h après le départ
        if (now()->diffInHours($tripStartTime, false) < -24) {
             return back()->with('error', 'Le délai de 24h pour signaler ce trajet est dépassé.');
        }

        // Création du signalement
        App\Models\Report::create([
            'reason' => $request->input('reason'),
            'description' => $request->input('description'),
            'status' => 'open',
            'trip_id' => $trip->id,
            'reported_user_id' => $reportedUserId,
            'reporter_id' => auth()->id(),
        ]);

        return back()->with('success', 'Votre signalement a été pris en compte.');

    })->name('trips.report');

    // Page "Mes publications"
    Route::get('/mes-publications', function () {
        $trips = App\Models\Trip::with(['vehicle', 'bookings.passenger'])
                    ->where('driver_id', auth()->id())
                    ->get()
                    ->sortByDesc('start_time');

        $upcoming = $trips->filter(fn($t) => $t->start_time >= now())->sortBy('start_time');
        $history = $trips->filter(fn($t) => $t->start_time < now());

        return view('publications', compact('upcoming', 'history'));
    })->name('publications');

    // API Interne : Récupération des véhicules
    Route::get('/api/user/vehicles', function () {
        return auth()->user()->vehicles()->get(['id', 'make', 'model', 'license_plate']);
    })->name('api.user.vehicles');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Messagerie
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
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

// Envoi du formulaire de contact
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// FAQ
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Mentions légales
Route::get('/legal/notice', function () {
    return view('legal.notice');
})->name('legal.notice');

// Politique de confidentialité
Route::get('/legal/privacy', function () {
    return view('legal.privacy');
})->name('legal.privacy');

// Conditions générales d'utilisation
Route::get('/legal/terms', function () {
    return view('legal.terms');
})->name('legal.terms');

// Auth routes
require __DIR__ . '/auth.php';
