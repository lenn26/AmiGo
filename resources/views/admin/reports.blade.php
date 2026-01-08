@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Gestion des signalements</h1>
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
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Signalé par</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Utilisateur visé</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Raison</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reports as $report)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $report->status === 'open' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $report->status === 'investigating' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $report->status === 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                                ">
                                    {{ 
                                        match($report->status) {
                                            'open' => 'Nouveau',
                                            'investigating' => 'En cours',
                                            'resolved' => 'Résolu',
                                            default => $report->status
                                        }
                                    }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $report->reporter->first_name }} {{ $report->reporter->last_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $report->reportedUser->first_name }} {{ $report->reportedUser->last_name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $report->reportedUser->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $report->description }}">
                                <div class="font-medium text-gray-900">{{ $report->reason }}</div>
                                <div class="text-xs">{{ Str::limit($report->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $report->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 pl-2 pr-6 py-1">
                                        <option value="open" {{ $report->status === 'open' ? 'selected' : '' }}>Nouveau</option>
                                        <option value="investigating" {{ $report->status === 'investigating' ? 'selected' : '' }}>En traitement</option>
                                        <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Résolu</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                Aucun signalement à traiter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $reports->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
