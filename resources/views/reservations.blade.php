<x-main-layout>
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <h1 class="text-3xl font-bold mb-8 text-gray-900 border-b pb-4">Mes Réservations</h1>

        <!-- Réservations à venir -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 flex items-center text-[#2794EB]">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Trajets à venir
            </h2>

            @if($upcoming->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
                    <p class="text-gray-500 text-lg mb-4">Aucun trajet prévu pour le moment.</p>
                    <a href="{{ route('trips') }}" class="inline-block px-6 py-2 bg-[#2794EB] text-white rounded-lg hover:bg-blue-600 transition">
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
                            <div class="flex flex-col items-end gap-2 min-w-[120px]">
                                <span class="text-xl font-bold text-[#333333]">{{ $booking->trip->price }} €</span>
                                @if($booking->status == 'confirmed')
                                    <span class="bg-[#70D78D] text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Confirmé</span>
                                @elseif($booking->status == 'pending')
                                    <span class="bg-yellow-400 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">En attente</span>
                                @else
                                    <span class="bg-gray-400 text-white px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider">{{ $booking->status }}</span>
                                @endif
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
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-5 flex flex-col md:flex-row items-center justify-between gap-4 hover:shadow-sm transition">
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
    </div>
</x-main-layout>
