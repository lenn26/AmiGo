@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Gestion des trajets</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Conducteur</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Trajet</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Véhicule</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prix</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Places</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <!-- Boucle pour afficher les trajets -->
                        @forelse($trips as $trip)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                #{{ $trip->id }}
                            </td>
                            <!-- Information du conducteur -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $trip->driver->first_name }} {{ $trip->driver->last_name }}</div>
                                <div class="text-xs text-gray-500">{{ $trip->driver->email }}</div>
                            </td>
                            <!-- Information du trajet -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $trip->start_location }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">> {{ $trip->end_location }}</div>
                            </td>
                            <!-- Date du trajet -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($trip->start_time)->format('d/m/Y H:i') }}
                            </td>
                            <!-- Information du véhicule -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->vehicle ? $trip->vehicle->make . ' ' . $trip->vehicle->model : 'N/A' }}
                            </td>
                            <!-- Prix du trajet -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $trip->price }} €
                            </td>
                            <!-- Places disponibles -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->seats_available }} / {{ $trip->total_seats }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.trips.delete', $trip) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Si aucun trajet n'est trouvé -->
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                Aucun trajet trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($trips->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $trips->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
