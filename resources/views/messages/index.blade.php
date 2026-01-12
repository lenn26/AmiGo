<x-main-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-[#333333] mb-8">Mes discussions</h1>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden min-h-[500px]">
            <div class="grid grid-cols-1 md:grid-cols-12 h-full">
                <!-- Liste des conversations -->
                <div class="col-span-1 md:col-span-12 h-full flex flex-col">
                    @if($formattedConversations->count() > 0)
                        <div class="divide-y divide-gray-100">
                            <!-- Boucle pour chaque conversation -->
                            @foreach($formattedConversations as $conversation)
                                <a href="{{ route('messages.show', ['user' => $conversation->user->id, 'trip_id' => $conversation->trip->id ?? null]) }}" class="block hover:bg-gray-50 transition-colors p-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <!-- Avatar de l'utilisateur -->
                                            @if($conversation->user->avatar)
                                                <img src="{{ $conversation->user->avatar }}" alt="{{ $conversation->user->first_name }}" class="w-14 h-14 rounded-full object-cover border border-gray-200">
                                            @else
                                                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-[#2794EB] font-bold text-xl">
                                                    {{ substr($conversation->user->first_name, 0, 1) }}
                                                </div>
                                            @endif
                                            
                                            <!-- Indicateur de messages non lus -->
                                            @if($conversation->unread_count > 0)
                                                <div class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                                                    {{ $conversation->unread_count }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline mb-1">
                                                <h3 class="font-bold text-gray-900 truncate">{{ $conversation->user->first_name }} {{ $conversation->user->last_name }}</h3>
                                                <span class="text-xs text-gray-500">{{ $conversation->last_message->created_at->diffForHumans() }}</span>
                                            </div>
                                            
                                            <!-- Affichage du trajet concerné -->
                                            @if($conversation->trip)
                                                <div class="mb-1">
                                                    <span class="inline-flex items-center gap-1 text-[12px] font-medium text-[#2794EB] bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">
                                                        <span>Trajet : {{ Str::limit($conversation->trip->start_address, 20) }} → {{ Str::limit($conversation->trip->end_address, 20) }}</span>
                                                        <span class="text-blue-400">•</span>
                                                        <span>{{ \Carbon\Carbon::parse($conversation->trip->start_time)->format('d/m H:i') }}</span>
                                                    </span>
                                                </div>
                                            @endif

                                            <p class="text-sm text-gray-500 truncate {{ $conversation->unread_count > 0 ? 'font-semibold text-gray-800' : '' }}">
                                                @if($conversation->last_message->from_user_id == auth()->id())
                                                    <span class="text-gray-400">Vous:</span>
                                                @endif
                                                {{ $conversation->last_message->content }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    <!-- Si aucune conversation n'existe -->
                    @else
                        <div class="flex flex-col items-center justify-center h-96 text-center p-8">
                            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-[#2794EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Aucune discussion</h3>
                            <p class="text-gray-500">Vos conversations avec les autres membres apparaîtront ici.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
