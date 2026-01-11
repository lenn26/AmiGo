<x-main-layout>
    <div class="container mx-auto px-4 py-8 max-w-5xl min-h-screen flex flex-col">
        <h1 class="text-3xl font-bold mb-8 text-gray-900 border-b pb-4">Mes publications</h1>

        <!-- Trajets à venir -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 flex items-center text-[#2794EB]">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                Trajets à venir
            </h2>

            @if($upcoming->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100 min-h-[300px] flex flex-col justify-center items-center">
                    <p class="text-gray-500 text-lg mb-6">Vous n'avez aucun trajet publié à venir.</p>
                    <a href="{{ route('trips.create') }}" class="inline-block px-8 py-3 bg-[#2794EB] text-white rounded-lg hover:bg-blue-600 transition text-lg font-medium">
                        Publier un trajet
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($upcoming as $trip)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4 transition hover:shadow-md">
                            <!-- Informations principales -->
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">
                                        {{ \Carbon\Carbon::parse($trip->start_time)->format('d/m/Y') }}
                                    </span>
                                    <span class="text-gray-900 font-bold text-lg">
                                        {{ \Carbon\Carbon::parse($trip->start_time)->format('H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-700 text-lg">
                                    <span class="font-medium">{{ $trip->start_address }}</span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="font-medium">{{ $trip->end_address }}</span>
                                </div>
                                <div class="mt-3 text-sm text-gray-500 flex items-center gap-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 17H16M8 17C8 18.1046 7.10457 19 6 19C4.89543 19 4 18.1046 4 17M8 17C8 15.8954 7.10457 15 6 15C4.89543 15 4 15.8954 4 17M16 17C16 18.1046 16.8954 19 18 19C19.1046 19 20 18.1046 20 17M16 17C16 15.8954 16.8954 15 18 15C19.1046 15 20 15.8954 20 17M10 5V11M4 11L4.33152 9.01088C4.56901 7.58593 4.68776 6.87345 5.0433 6.3388C5.35671 5.8675 5.79705 5.49447 6.31346 5.26281C6.8993 5 7.6216 5 9.06621 5H12.4311C13.3703 5 13.8399 5 14.2662 5.12945C14.6436 5.24406 14.9946 5.43194 15.2993 5.68236C15.6435 5.96523 15.904 6.35597 16.425 7.13744L19 11M4 17H3.6C3.03995 17 2.75992 17 2.54601 16.891C2.35785 16.7951 2.20487 16.6422 2.10899 16.454C2 16.2401 2 15.9601 2 15.4V14.2C2 13.0799 2 12.5198 2.21799 12.092C2.40973 11.7157 2.71569 11.4097 3.09202 11.218C3.51984 11 4.0799 11 5.2 11H17.2C17.9432 11 18.3148 11 18.6257 11.0492C20.3373 11.3203 21.6797 12.6627 21.9508 14.3743C22 14.6852 22 15.0568 22 15.8C22 15.9858 22 16.0787 21.9877 16.1564C21.9199 16.5843 21.5843 16.9199 21.1564 16.9877C21.0787 17 20.9858 17 20.8 17H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $trip->vehicle ? $trip->vehicle->make . ' ' . $trip->vehicle->model : 'Véhicule supprimé' }}
                                    </span>
                                    <span class="text-gray-300">|</span>
                                    <span class="text-green-600 font-medium">{{ $trip->seats_available }} places dispo</span>
                                </div>
                            </div>
                            
                            <!-- Prix et Actions -->
                            <div class="flex flex-col items-end gap-3 min-w-[140px]" x-data="{ showDeleteModal: false }">
                                <span class="text-2xl font-bold text-[#333333]">{{ $trip->price }} €</span>
                                
                                <button type="button" @click="showDeleteModal = true" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center gap-1 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Annuler
                                </button>

                                <!-- Modal de confirmation -->
                                <div x-show="showDeleteModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showDeleteModal = false"></div>

                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                            Supprimer le trajet
                                                        </h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500">
                                                                Êtes-vous sûr de vouloir supprimer ce trajet ? Cette action est irréversible.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <form action="{{ route('trips.destroy', $trip) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                                        Supprimer
                                                    </button>
                                                </form>
                                                <button type="button" @click="showDeleteModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Annuler
                                                </button>
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
                if (!this.active || !this.active.reports) return false;
                return this.active.reports.some(r => r.reported_user_id == userId);
            },

            // Vérifie s'il reste au moins un passager à signaler sur ce trajet
            canReportAnyone() {
                if (!this.active || !this.active.bookings) return false;
                
                for (let booking of this.active.bookings) {
                        if (booking.passenger && !this.hasReportedUser(booking.passenger.id)) {
                            return true;
                        }
                }
                
                return false;
            }
        }">
            <h2 class="text-2xl font-semibold mb-6 flex items-center text-gray-600">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historique des publications
            </h2>

            @if($history->isEmpty())
                <p class="text-gray-500 italic ml-2">Vous n'avez encore publié aucun trajet passé.</p>
            @else
                <div class="space-y-4 opacity-75">
                    @foreach($history as $trip)
                         @php
                            // Charge les relations
                            $trip->load(['vehicle', 'bookings.passenger', 'reports']);
                            // On filtre les reports pour savoir s'il y en a UN de l'utilisateur courant (le conducteur) et on réindexe
                            $trip->setRelation('reports', $trip->reports->where('reporter_id', auth()->id())->values());
                            // Données complètes
                            $jsData = $trip;
                        @endphp
                        
                        <div 
                            @dblclick="active = {{ json_encode($jsData) }}; showHistoryModal = true; showReportForm = false"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4 cursor-pointer hover:shadow-md transition duration-200"
                        >
                            <div class="flex-grow">
                                <span class="text-sm text-gray-500 mb-1 block">
                                    {{ \Carbon\Carbon::parse($trip->start_time)->isoFormat('LL') }}
                                </span>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <span class="font-medium">{{ $trip->start_address }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span class="font-medium">{{ $trip->end_address }}</span>
                                </div>
                            </div>
                            <div class="text-right flex flex-col items-end">
                                <span class="block font-bold text-gray-700">{{ $trip->price }} €</span>
                                <span class="text-xs text-gray-500 mt-1 mb-2">Terminé</span>
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

                 <!-- Modal de détail -->
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
                                        <h3 class="text-2xl font-bold text-gray-800" x-text="showReportForm ? 'Signaler un passager' : 'Détail de la publication'"></h3>
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
                                                        <p class="font-bold text-xl text-gray-900" x-text="new Date(active.start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></p>
                                                        <p class="text-gray-500" x-text="active.start_address"></p>
                                                    </div>
                                                    <!-- Arrivée -->
                                                    <div class="relative">
                                                        <span class="absolute -left-[31px] bg-white border-2 border-green-500 w-4 h-4 rounded-full"></span>
                                                        <p class="font-bold text-xl text-gray-900" x-text="new Date(active.end_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></p>
                                                        <p class="text-gray-500" x-text="active.end_address"></p>
                                                    </div>
                                                </div>

                                                <!-- Description -->
                                                <template x-if="active.description">
                                                    <div class="mt-8">
                                                        <h4 class="text-gray-900 font-bold mb-2">À propos du trajet</h4>
                                                        <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-4 rounded-lg" x-text="active.description"></p>
                                                    </div>
                                                </template>

                                                <!-- Passagers -->
                                                <div class="mt-8 pt-6 border-t border-gray-100">
                                                    <h4 class="text-gray-900 font-bold mb-4">Passagers</h4>
                                                    <template x-if="active.bookings && active.bookings.length > 0">
                                                        <div class="space-y-3">
                                                            <template x-for="booking in active.bookings">
                                                                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                                                     <template x-if="booking.passenger.avatar">
                                                                        <img :src="booking.passenger.avatar" class="w-10 h-10 rounded-full mr-3 object-cover">
                                                                    </template>
                                                                    <template x-if="!booking.passenger.avatar">
                                                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3" x-text="booking.passenger.first_name.charAt(0)"></div>
                                                                    </template>
                                                                    <div>
                                                                        <p class="font-medium text-gray-900" x-text="booking.passenger.first_name + ' ' + booking.passenger.last_name"></p>
                                                                        <p class="text-xs text-gray-500" x-text="booking.seats_booked + ' place(s)'"></p>
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                    <template x-if="!active.bookings || active.bookings.length === 0">
                                                        <p class="text-gray-500 italic">Aucun passager</p>
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
                                                        <span class="font-medium text-gray-900" x-text="active.vehicle ? (active.vehicle.make + ' ' + active.vehicle.model) : 'Non spécifié'"></span>
                                                    </div>
                                                    <div class="flex justify-between border-b border-gray-50 pb-2">
                                                        <span class="text-gray-500">Couleur</span>
                                                        <span class="font-medium text-gray-900" x-text="active.vehicle ? active.vehicle.color : '-'"></span>
                                                    </div>
                                                    <div class="flex justify-between border-b border-gray-50 pb-2">
                                                        <span class="text-gray-500">Date</span>
                                                        <span class="font-medium text-gray-900 first-letter:uppercase" x-text="new Date(active.start_time).toLocaleDateString(undefined, {weekday:'long', day:'numeric', month:'long'})"></span>
                                                    </div>
                                                    <div class="flex justify-between items-center pt-2">
                                                        <span class="text-gray-500">Places restantes</span>
                                                        <span class="font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded" x-text="active.seats_available"></span>
                                                    </div>
                                                    <div class="flex justify-between items-center pt-2">
                                                        <span class="text-gray-500">Revenus générés</span>
                                                        <span class="font-bold text-green-600 text-lg" x-text="new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(active.price * (active.bookings ? active.bookings.reduce((acc, b) => acc + b.seats_booked, 0) : 0))"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <!-- Vue formulaire de signalement -->
                                    <div x-show="showReportForm" class="p-8">
                                        <form :action="'/trips/' + active.id + '/report'" method="POST">
                                            @csrf
                                            
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Qui voulez-vous signaler ?</label>
                                                <select name="reported_user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                                                    <option value="" disabled selected>Sélectionnez un passager</option>
                                                    
                                                    <!-- Option Passagers -->
                                                    <template x-for="booking in active.bookings">
                                                        <option :value="booking.passenger.id"
                                                                :disabled="hasReportedUser(booking.passenger.id)"
                                                                x-text="booking.passenger.first_name + ' ' + booking.passenger.last_name + (hasReportedUser(booking.passenger.id) ? ' (Déjà signalé)' : '')">
                                                        </option>
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
                                                    <optgroup label="Autre">
                                                        <option value="Paiement non honoré">Paiement non honoré</option>
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
                                                        Tous les passagers ont été signalés
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
                                            <p class="text-sm text-gray-500">Prix par place</p>
                                            <p class="text-3xl font-bold text-gray-900" x-text="new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(active.price)"></p>
                                        </div>
                                        
                                        <!-- Logique d'affichage du bouton Signaler -->
                                        <div>
                                            <template x-if="check24h(active.start_time)">
                                                <div>
                                                     <template x-if="!active.bookings || active.bookings.length === 0">
                                                        <span class="text-gray-400 italic text-sm">Aucun passager à signaler</span>
                                                     </template>
                                                     <template x-if="active.bookings && active.bookings.length > 0">
                                                        <div>
                                                            <template x-if="!canReportAnyone()">
                                                                <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-gray-100 italic">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                    Signalements effectués
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
                                                </div>
                                            </template>
                                            <template x-if="!check24h(active.start_time)">
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
