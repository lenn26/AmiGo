<x-main-layout>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-[#333333]">Notifications</h1>
            
            <!-- Bouton pour marquer toutes les notifications comme lues -->
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-[#2794EB] hover:underline font-medium">
                        Tout marquer comme lu
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <!-- Liste des notifications -->
            @forelse($notifications as $notification)
                <div class="p-6 border-b border-gray-100 flex items-start gap-4 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50/50' }} hover:bg-gray-50 transition">
                    <div class="flex-shrink-0 mt-1">
                        @if($notification->type === 'booking')
                            <div class="w-10 h-10 bg-[#2794EB]/10 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#2794EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @elseif($notification->type === 'message')
                            <div class="w-10 h-10 bg-[#70D78D]/10 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#70D78D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                        @else
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Contenu de la notification -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800 {{ $notification->is_read ? '' : 'font-semibold' }}">
                            {{ $notification->message }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Bouton pour marquer la notification comme lue -->
                    @if(!$notification->is_read)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex-shrink-0 text-xs text-[#2794EB] hover:underline whitespace-nowrap">
                                Marquer comme lu
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <p class="text-lg font-medium">Aucune notification</p>
                    <p class="text-sm">Vous n'avez pas encore de notifications.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-main-layout>
