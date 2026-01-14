<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // IMPORTANT : Ne pas oublier cet import
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Force le HTTPS en production (Répare ton problème Tailwind/CSS)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 2. Format des dates en français
        \Carbon\Carbon::setLocale('fr');

        // 3. Mise à jour des statuts (uniquement si on n'est pas en train de compiler/builder)
        // On vérifie si on est en console pour éviter de bloquer le build
        if (!app()->runningInConsole()) {
            try {
                if (Schema::hasTable('trips')) {
                    \App\Models\Trip::where('end_time', '<', now()->subHours(2))
                        ->whereIn('status', ['planned', 'open', 'full'])
                        ->update(['status' => 'completed']);
                }
            } catch (\Exception $e) {
                // On log l'erreur mais on ne fait pas planter l'application
                Log::error("Erreur mise à jour trajets: " . $e->getMessage());
            }
        }
    }
}