<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // Format des dates en français
        \Carbon\Carbon::setLocale('fr');

        // Mise à jour automatique des statuts des trajets
        // Le trajet est marqué comme terminé 2h après l'arrivée pour laisser un délai de signalement
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('trips')) {
                \App\Models\Trip::where('end_time', '<', now()->subHours(2))
                    ->whereIn('status', ['planned', 'open', 'full'])
                    ->update(['status' => 'completed']);
            }
        } catch (\Exception $e) {
            // Évite de bloquer l'application si la DB n'est pas encore migrée
        }
    }
}
