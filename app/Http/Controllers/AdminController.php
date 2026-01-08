<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trip;
use App\Models\University;
use App\Models\Report;
use App\Models\LogAdmin;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users_count' => User::count(),
            'trips_today' => Trip::whereDate('start_time', now())->count(),
            'fill_rate' => '85%',
            'reports_count' => Report::where('status', 'open')->count(),
        ];
        
        $logs = LogAdmin::with(['admin', 'targetUser'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'logs'));
    }

    public function trips(): View
    {
        $trips = Trip::with(['driver', 'vehicle'])->latest()->paginate(10);
        return view('admin.trips', compact('trips'));
    }

    public function deleteTrip(Trip $trip)
    {
        $trip->delete();
        return back()->with('success', 'Trajet supprimé avec succès.');
    }

    public function users(): View
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        // Empêcher la suppression de soi-même ou d'autres admins principaux si nécessaire
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function campus(): View
    {
        $campuses = University::latest()->paginate(10);
        return view('admin.campus', compact('campuses'));
    }

    public function storeCampus(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        University::create($request->all());

        return back()->with('success', 'Campus ajouté avec succès.');
    }

    public function deleteCampus(University $university)
    {
        $university->delete();
        return back()->with('success', 'Campus supprimé avec succès.');
    }

    public function reports(): View
    {
        $reports = Report::with(['reporter', 'reportedUser', 'trip'])
            ->orderByRaw("FIELD(status, 'open', 'investigating', 'resolved')")
            ->latest()
            ->paginate(10);
            
        return view('admin.reports', compact('reports'));
    }

    public function updateReport(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:open,investigating,resolved'
        ]);

        $report->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Statut du signalement mis à jour.');
    }
}

