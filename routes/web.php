<?php

use App\Http\Controllers\ProfileController;
use App\Models\University;
use App\Models\Trip;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $universities = University::all();
    return view('index', compact('universities'));
});

use Illuminate\Http\Request;

// Route pour la recherche de trajets avec les filtres.
// Les filtres sont appliqués via des paramètres dans l'URL.
Route::get('/trajets', function (Request $request) {
    $query = Trip::with('driver')->where('status', '!=', 'completed');

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

require __DIR__ . '/auth.php';
