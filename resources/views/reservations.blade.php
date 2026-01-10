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
        <section>
            <h2 class="text-2xl font-semibold mb-6 flex items-center text-gray-600">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Historique
            </h2>

            @if($history->isEmpty())
                <p class="text-gray-500 italic ml-2">Vous n'avez pas encore effectué de trajet.</p>
            @else
                <div class="space-y-4 opacity-75">
                     @foreach($history as $booking)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
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
                            <div class="text-right">
                                <span class="block font-bold text-gray-900">{{ $booking->trip->price }} €</span>
                                <span class="text-xs text-green-600 font-semibold">Terminé</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
        <div class="h-48 md:h-64"></div>
    </div>
</x-main-layout>
