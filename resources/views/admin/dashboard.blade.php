@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900">Vue d'ensemble</h1>
        <p class="mt-1 text-gray-500">Bienvenue sur le panneau d'administration AmiGo.</p>

        <!-- Carte des statistiques -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Carte 1 (étudiants inscrits) -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['users_count'] }}</h3>
                <p class="text-sm text-gray-500 font-medium mt-1">Etudiants inscrits</p>
            </div>

            <!-- Carte 2 (trajets aujourd'hui) -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['trips_today'] }}</h3>
                <p class="text-sm text-gray-500 font-medium mt-1">Trajets aujourd'hui</p>
            </div>

            <!-- Carte 3 (taux de remplissage) -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-4 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['fill_rate'] }}</h3>
                <p class="text-sm text-gray-500 font-medium mt-1">Taux de remplissage</p>
            </div>

            <!-- Carte 4 (signalements à traiter) -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mb-4 text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900">{{ $stats['reports_count'] }}</h3>
                <p class="text-sm text-gray-500 font-medium mt-1">Signalement à traiter</p>
            </div>
        </div>

        <!-- Section des logs -->
        <h2 class="text-2xl font-bold text-gray-900 mt-10 mb-6">Dernières actions (Logs)</h2>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cible (ID)</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Boucle pour afficher les logs -->
                        @forelse($logs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Affichage des informations de l'admin -->
                                <div class="text-sm font-medium text-gray-900">{{ $log->admin->first_name ?? 'Unknown' }}</div>
                                <div class="text-xs text-gray-500">{{ $log->admin->role ?? 'Admin' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ str_contains(strtolower($log->action), 'suppression') ? 'bg-red-100 text-red-700' : '' }}
                                    {{ str_contains(strtolower($log->action), 'avertissement') ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ str_contains(strtolower($log->action), 'ajout') ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ !str_contains(strtolower($log->action), 'suppression') && !str_contains(strtolower($log->action), 'avertissement') && !str_contains(strtolower($log->action), 'ajout') ? 'bg-gray-100 text-gray-700' : '' }}
                                ">
                                    <!-- Affichage de l'action effectuée -->
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <!-- Affichage de la cible de l'action -->
                                {{ $log->targetUser ? 'User #' . $log->targetUser->id . ' (' . $log->targetUser->first_name . ')' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <!-- Affichage de la date de l'action -->
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        <!-- Si il n'y a pas de log -->
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                Aucune action récente enregistrée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
