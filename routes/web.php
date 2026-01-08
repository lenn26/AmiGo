<?php

use App\Http\Controllers\ProfileController;
use App\Models\University;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/api/locations', [App\Http\Controllers\UniversityController::class, 'search'])->name('api.universities.search');

use Illuminate\Http\Request;
use App\Models\Trip;

Route::get('/trajets', function (Request $request) {
    // On ne veut que les trajets futurs et non terminés
    // Donc on filtre sur la date de début et le statut du trajet
    $query = Trip::with('driver')
                ->where('status', '!=', 'completed')
                ->where('start_time', '>=', now());

    if ($request->filled('from')) {
        // On découpe la chaîne en mots-clés pour pouvoir faire une recherche plus flexible
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
    
    // Filters buttons
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

Route::middleware('auth')->get('/proposer-trajet', function () {
    $userTrips = Trip::where('driver_id', auth()->id())
                    ->orderBy('start_time', 'asc')
                    ->get();
    $vehicles = Vehicle::where('owner_id', auth()->id())->get();
    return view('propose', compact('userTrips', 'vehicles'));
})->name('trips.create');

Route::post('/proposer-trajet', [TripController::class, 'store'])->name('trips.store')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

require __DIR__ . '/auth.php';
