<x-main-layout>
    <div class="container mx-auto px-4 py-8 h-[calc(100vh-100px)]">
        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
            
            <!-- En-tête de la discussion -->
            <div class="p-4 border-b border-gray-100 bg-white flex items-center gap-4 sticky top-0 z-10">
                <a href="{{ route('messages.index') }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                
                <!-- Informations de l'utilisateur -->
                <div class="flex items-center gap-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->first_name }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-[#2794EB] font-bold text-sm">
                            {{ substr($user->first_name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h2 class="font-bold text-gray-900 leading-tight">{{ $user->first_name }} {{ $user->last_name }}</h2>
                        <span class="text-xs text-green-500 font-medium">En ligne</span>
                    </div>
                </div>

                <!-- Informations sur le trajet lié -->
                @if(isset($trip) && $trip)
                    <div class="ml-auto md:ml-6 pl-4 md:border-l border-gray-100 flex flex-col items-end md:items-start">
                        <span class="text-[10px] font-bold text-[#2794EB] uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded-full">Trajet lié</span>
                        <div class="text-xs text-gray-600 mt-0.5">
                            {{ Str::limit($trip->start_address, 20) }} <span class="text-gray-400">→</span> {{ Str::limit($trip->end_address, 20) }}
                        </div>
                        <div class="text-[10px] text-gray-400">
                            {{ \Carbon\Carbon::parse($trip->start_time)->format('d M à H:i') }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Zone des messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50" id="messages-container">
                @foreach($messages as $message)
                    @php
                        $isMe = $message->from_user_id === auth()->id();
                    @endphp
                    
                    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] {{ $isMe ? 'bg-[#2794EB] text-white rounded-br-none' : 'bg-white text-gray-800 rounded-bl-none shadow-sm' }} px-5 py-3 rounded-2xl">
                            <p class="text-sm">{{ $message->content }}</p>
                            <div class="text-[10px] mt-1 {{ $isMe ? 'text-blue-100 text-right' : 'text-gray-400' }}">
                                {{ $message->created_at->format('H:i') }}
                                @if($isMe && $message->is_read)
                                    <span class="ml-1">✓✓</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Formulaire d'envoi -->
            <div class="p-4 bg-white border-t border-gray-100">
                <form action="{{ route('messages.store', $user) }}" method="POST" class="flex items-center gap-3">
                    <!-- Champ CSRF -->
                    @csrf
                    @if(isset($trip) && $trip)
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    @endif
                    <input type="text" name="content" 
                        class="flex-1 bg-gray-100 border-none rounded-full px-6 py-3 focus:ring-2 focus:ring-[#2794EB] focus:bg-white transition-all outline-none" 
                        placeholder="Écrivez votre message..." 
                        autocomplete="off" 
                        autofocus>
                    
                    <!-- Bouton d'envoi -->
                    <button type="submit" class="w-12 h-12 bg-[#2794EB] hover:bg-blue-600 text-white rounded-full flex items-center justify-center transition-transform hover:scale-105 shadow-md">
                        <svg class="w-5 h-5 rotate-90 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Scroll automatique vers le bas
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    </script>
</x-main-layout>
