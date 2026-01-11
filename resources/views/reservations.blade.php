<x-main-layout>
    <div class="container mx-auto px-4 py-8 max-w-5xl min-h-screen flex flex-col">
        <h1 class="text-3xl font-bold mb-8 text-gray-900 border-b pb-4">Mes trajets</h1>


        <!-- Mes trajets reservés -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 flex items-center text-[#2794EB]">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Réservés
            </h2>

            @if($upcoming->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100 min-h-[400px] flex flex-col justify-center items-center">
                    <p class="text-gray-500 text-lg mb-6">Aucun trajet prévu pour le moment.</p>
                    <a href="{{ route('trips') }}" class="inline-block px-8 py-3 bg-[#2794EB] text-white rounded-lg hover:bg-blue-600 transition text-lg font-medium">
                        Rechercher un trajet
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($upcoming as $booking)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                            <!-- Informations principales -->
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">
                                        {{ \Carbon\Carbon::parse($booking->trip->start_time)->format('d/m/Y') }}
                                    </span>
                                    <span class="text-gray-900 font-bold text-lg">
                                        {{ \Carbon\Carbon::parse($booking->trip->start_time)->format('H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <span class="font-medium">{{ $booking->trip->start_address }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="font-medium">{{ $booking->trip->end_address }}</span>
                                </div>
                                <div class="mt-2 text-sm text-gray-500 flex items-center gap-2">
                                    <div class="flex items-center">
                                        @if($booking->trip->driver->avatar)
                                            <img src="{{ $booking->trip->driver->avatar }}" alt="{{ $booking->trip->driver->first_name }}" class="w-6 h-6 rounded-full border border-gray-200 mr-2">
                                        @else
                                            <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center mr-2 text-xs">
                                                {{ substr($booking->trip->driver->first_name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span>Conducteur : {{ $booking->trip->driver->first_name }}</span>
                                    </div>
                                    <span class="text-gray-300">|</span>
                                    <span>{{ $booking->seats_booked }} place(s)</span>
                                </div>
                            </div>
                            
                            <!-- Statut et Prix -->
                            <div class="flex flex-col items-end gap-2 min-w-[140px]" x-data="{ showCancelModal: false }">
                                <span class="text-xl font-bold text-[#333333]">{{ number_format($booking->trip->price * $booking->seats_booked, 2, ',', ' ') }} €</span>
                                @if($booking->status == 'confirmed')
                                    <span class="bg-[#70D78D] text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2">Confirmé</span>
                                @elseif($booking->status == 'pending')
                                    <span class="bg-yellow-400 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2">En attente</span>
                                @else
                                    <span class="bg-gray-400 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2">{{ $booking->status }}</span>
                                @endif

                                <button type="button" @click="showCancelModal = true" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Annuler
                                </button>

                                <!-- Modal de confirmation -->
                                <div x-show="showCancelModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="showCancelModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showCancelModal = false"></div>

                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <div x-show="showCancelModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                            Annuler la réservation
                                                        </h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500">
                                                                Êtes-vous sûr de vouloir annuler cette réservation ?
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <form action="{{ route('bookings.destroy', $booking) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                            Confirmer l'annulation
                                                        </button>
                                                    </form>
                                                    <button type="button" @click="showCancelModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Retour
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Historique -->
        <section x-data="{ 
            showHistoryModal: false, 
            active: null, 
            showReportForm: false,
            
            check24h(dateString) {
                const tripDate = new Date(dateString);
                const now = new Date();
                const diffMs = now - tripDate;
                const diffHrs = diffMs / (1000 * 60 * 60);
                return diffHrs < 24;
            },

            // Vérifie si un utilisateur spécifique a déjà été signalé
            hasReportedUser(userId) {
                if (!this.active || !this.active.trip.reports) return false;
                return this.active.trip.reports.some(r => r.reported_user_id == userId);
            },

            // Vérifie s'il reste au moins une personne à signaler sur ce trajet
            canReportAnyone() {
                if (!this.active) return false;
                
                // Vérifier le conducteur
                if (!this.hasReportedUser(this.active.trip.driver_id)) return true;
                
                // Vérifier les passagers (sauf moi-même)
                if (this.active.trip.bookings) {
                     for (let booking of this.active.trip.bookings) {
                         if (booking.passenger.id !== {{ auth()->id() }} && !this.hasReportedUser(booking.passenger.id)) {
                             return true;
                         }
                     }
                }
                
                return false;
            }
        }">
            <h2 class="text-2xl font-semibold mb-6 flex items-center text-gray-600">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historique
            </h2>

            @if($history->isEmpty())
                <p class="text-gray-500 italic ml-2">Vous n'avez pas encore effectué de trajet.</p>
            @else
                <div class="space-y-4 opacity-75">
                     @foreach($history as $booking)
                        <!-- On prépare les données pour JS : on charge les relations nécessaires -->
                        @php
                            // D'abord on charge tout ce qu'il faut
                            $booking->load(['trip.driver', 'trip.vehicle', 'trip.bookings.passenger', 'trip.reports']);
                            
                            // Ensuite on filtre les reports pour ne garder que ceux de l'utilisateur courant (et on réindexe avec values())
                            $booking->trip->setRelation('reports', $booking->trip->reports->where('reporter_id', auth()->id())->values());
                            
                            $jsData = $booking;
                        @endphp

                        <div 
                            @dblclick="active = {{ json_encode($jsData) }}; showHistoryModal = true; showReportForm = false"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4 cursor-pointer hover:shadow-md transition duration-200"
                        >
                            <div class="flex-grow">
                                <span class="text-sm text-gray-500 mb-1 block">
                                    {{ \Carbon\Carbon::parse($booking->trip->start_time)->isoFormat('LL') }}
                                </span>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <span class="font-medium">{{ $booking->trip->start_address }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="font-medium">{{ $booking->trip->end_address }}</span>
                                </div>
                            </div>
                            <div class="text-right flex flex-col items-end">
                                <span class="block font-bold text-gray-900">{{ number_format($booking->trip->price * $booking->seats_booked, 2, ',', ' ') }} €</span>
                                <span class="text-xs text-green-600 font-semibold mt-2 mb-2">Terminé</span>
                                
                                <button 
                                    @click.stop="active = {{ json_encode($jsData) }}; showHistoryModal = true; showReportForm = false"
                                    class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center gap-1 transition"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Voir plus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal de détail (Même style que celui de la recherche de trajet) -->
                <div x-show="showHistoryModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Fond sombre -->
                        <div x-show="showHistoryModal" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showHistoryModal = false">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <!-- Contenu du modal -->
                        <div x-show="showHistoryModal" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                            
                            <template x-if="active">
                                <div>
                                    <!-- Entête -->
                                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                        <h3 class="text-2xl font-bold text-gray-800" x-text="showReportForm ? 'Signaler un problème' : 'Détail du trajet passé'"></h3>
                                        <button @click="showHistoryModal = false" class="text-gray-400 hover:text-gray-600 transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <!-- Vue détails -->
                                    <div x-show="!showReportForm" class="p-8">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                            <!-- Colonne gauche -->
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    Itinéraire
                                                </h4>
                                                
                                                <div class="relative pl-6 border-l-2 border-gray-100 ml-2 space-y-8">
                                                    <!-- Départ -->
                                                    <div class="relative">
                                                        <span class="absolute -left-[31px] bg-white border-2 border-blue-500 w-4 h-4 rounded-full"></span>
                                                        <p class="font-bold text-xl text-gray-900" x-text="new Date(active.trip.start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></p>
                                                        <p class="text-gray-500" x-text="active.trip.start_address"></p>
                                                    </div>
                                                    <!-- Arrivée -->
                                                    <div class="relative">
                                                        <span class="absolute -left-[31px] bg-white border-2 border-green-500 w-4 h-4 rounded-full"></span>
                                                        <p class="font-bold text-xl text-gray-900" x-text="new Date(active.trip.end_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></p>
                                                        <p class="text-gray-500" x-text="active.trip.end_address"></p>
                                                    </div>
                                                </div>

                                                <!-- Description -->
                                                <template x-if="active.trip.description">
                                                    <div class="mt-8">
                                                        <h4 class="text-gray-900 font-bold mb-2">À propos du trajet</h4>
                                                        <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-4 rounded-lg" x-text="active.trip.description"></p>
                                                    </div>
                                                </template>

                                                <!-- Conducteur -->
                                                <div class="mt-8 pt-6 border-t border-gray-100">
                                                    <h4 class="text-gray-900 font-bold mb-4">Information Conducteur</h4>
                                                    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                                        <template x-if="active.trip.driver.avatar">
                                                            <img :src="active.trip.driver.avatar" class="w-12 h-12 rounded-full mr-4 object-cover">
                                                        </template>
                                                        <template x-if="!active.trip.driver.avatar">
                                                            <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl mr-4" x-text="active.trip.driver.first_name.charAt(0)"></div>
                                                        </template>
                                                        <div>
                                                            <p class="font-bold text-gray-900 text-lg" x-text="active.trip.driver.first_name + ' ' + active.trip.driver.last_name.charAt(0) + '.'"></p>
                                                            <div class="flex items-center text-yellow-500 text-sm">
                                                                <span>★ 4.8/5</span> <span class="text-gray-400 ml-1 text-xs">(12 avis)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <template x-if="active.trip.driver.bio">
                                                        <p class="text-gray-500 text-sm mt-3 italic" x-text="'“' + active.trip.driver.bio + '”'"></p>
                                                    </template>
                                                </div>
                                            </div>

                                            <!-- Colonne droite -->
                                            <div>
                                                <h4 class="text-lg font-bold text-gray-700 mb-4 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Details
                                                </h4>
                                                <div class="space-y-4">
                                                    <div class="flex justify-between border-b border-gray-50 pb-2">
                                                        <span class="text-gray-500">Véhicule</span>
                                                        <span class="font-medium text-gray-900" x-text="active.trip.vehicle ? (active.trip.vehicle.make + ' ' + active.trip.vehicle.model) : 'Non spécifié'"></span>
                                                    </div>
                                                    <div class="flex justify-between border-b border-gray-50 pb-2">
                                                        <span class="text-gray-500">Couleur</span>
                                                        <span class="font-medium text-gray-900" x-text="active.trip.vehicle ? active.trip.vehicle.color : '-'"></span>
                                                    </div>
                                                    <div class="flex justify-between border-b border-gray-50 pb-2">
                                                        <span class="text-gray-500">Date</span>
                                                        <span class="font-medium text-gray-900 first-letter:uppercase" x-text="new Date(active.trip.start_time).toLocaleDateString(undefined, {weekday:'long', day:'numeric', month:'long'})"></span>
                                                    </div>
                                                    <div class="flex justify-between items-center pt-2">
                                                        <span class="text-gray-500">Vos places</span>
                                                        <span class="font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded" x-text="active.seats_booked"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Vue formulaire de signalement -->
                                    <div x-show="showReportForm" class="p-8">
                                        <form :action="'/reservations/' + active.id + '/report'" method="POST">
                                            @csrf
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Qui voulez-vous signaler ?</label>
                                                <select name="reported_user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                                    <option value="" disabled selected>Sélectionnez une personne</option>
                                                    
                                                    <!-- Option Conducteur -->
                                                    <option :value="active.trip.driver.id" 
                                                            :disabled="hasReportedUser(active.trip.driver.id)"
                                                            x-text="'Conducteur : ' + active.trip.driver.first_name + ' ' + active.trip.driver.last_name + (hasReportedUser(active.trip.driver.id) ? ' (Déjà signalé)' : '')">
                                                    </option>

                                                    <!-- Option Passagers -->
                                                    <template x-for="pBooking in active.trip.bookings">
                                                        <template x-if="pBooking.passenger && pBooking.passenger.id !== {{ auth()->id() }}">
                                                            <option :value="pBooking.passenger.id"
                                                                    :disabled="hasReportedUser(pBooking.passenger.id)"
                                                                    x-text="'Passager : ' + pBooking.passenger.first_name + ' ' + pBooking.passenger.last_name + (hasReportedUser(pBooking.passenger.id) ? ' (Déjà signalé)' : '')">
                                                            </option>
                                                        </template>
                                                    </template>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Raison du signalement</label>
                                                <select name="reason" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                                    <option value="" disabled selected>Sélectionnez une raison</option>
                                                    <optgroup label="Comportement">
                                                        <option value="Absence au rendez-vous">Absence au rendez-vous</option>
                                                        <option value="Retard important">Retard important</option>
                                                        <option value="Comportement inapproprié">Comportement inapproprié / Agressivité</option>
                                                        <option value="Non-respect des règles">Non-respect des règles</option>
                                                    </optgroup>
                                                    <optgroup label="Sécurité & Conduite">
                                                        <option value="Conduite dangereuse">Conduite dangereuse</option>
                                                        <option value="Véhicule non conforme">Véhicule non conforme / Sale</option>
                                                        <option value="Non-respect du code de la route">Non-respect du code de la route</option>
                                                    </optgroup>
                                                    <optgroup label="Autre">
                                                        <option value="Demande de paiement supplémentaire">Demande de paiement supplémentaire</option>
                                                        <option value="Autre">Autre</option>
                                                    </optgroup>
                                                </select>
                                            </div>

                                            <div class="mb-6">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Description du problème</label>
                                                <textarea name="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Décrivez la situation en quelques mots..." required></textarea>
                                            </div>

                                            <div class="mb-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
                                                <template x-if="!canReportAnyone()">
                                                    <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-gray-100 italic">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        Aucune personne à signaler
                                                    </span>
                                                </template>
                                                <template x-if="canReportAnyone()">
                                                    <div class="flex gap-3">
                                                        <button type="button" @click="showReportForm = false" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">Retour</button>
                                                        <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium shadow-md">Envoyer le signalement</button>
                                                    </div>
                                                </template>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Footer (Visible seulement en mode Détails) -->
                                    <div x-show="!showReportForm" class="bg-gray-50 px-8 py-5 flex items-center justify-between border-t border-gray-100">
                                        <div>
                                            <p class="text-sm text-gray-500">Prix payé</p>
                                            <p class="text-3xl font-bold text-gray-900" x-text="new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(active.trip.price * active.seats_booked)"></p>
                                        </div>
                                        
                                        <!-- Logique d'affichage du bouton Signaler -->
                                        <div>
                                            <template x-if="check24h(active.trip.start_time)">
                                                <div>
                                                    <template x-if="!canReportAnyone()">
                                                        <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-gray-100 italic">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            Déjà signalé (Plus personne à signaler)
                                                        </span>
                                                    </template>
                                                    <template x-if="canReportAnyone()">
                                                        <button @click="showReportForm = true" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                            Signaler un problème
                                                        </button>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!check24h(active.trip.start_time)">
                                                <span class="text-gray-400 text-sm italic">Délai de signalement dépassé</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <div class="h-48 md:h-64"></div>
    </div>
</x-main-layout>
