<x-main-layout>
    <div class="container mx-auto px-6 py-8">
        
        <!-- Billets à venir -->
        @auth
            @if(isset($upcoming_bookings) && $upcoming_bookings->count() > 0)
                @foreach($upcoming_bookings as $booking)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-2 pl-8 pr-2 mb-8 flex items-center justify-between">
                    <div class="flex items-center gap-4 text-[#333333]">
                        <span class="font-bold text-lg">Billet à venir:</span>
                        <span class="text-gray-600">
                            {{ $booking->trip->start_time->isTomorrow() ? 'Demain' : ($booking->trip->start_time->isToday() ? "Aujourd'hui" : $booking->trip->start_time->format('d/m')) }} 
                            - {{ $booking->trip->start_time->format('H\hi') }}
                        </span>
                        <span class="text-gray-400">|</span>
                        <span class="font-medium">{{ Str::limit($booking->trip->start_address, 20) }} &rarr; {{ Str::limit($booking->trip->end_address, 20) }}</span>
                    </div>
                    <span class="{{ in_array($booking->status, ['accepted', 'confirmed']) ? 'bg-[#70D78D]' : 'bg-orange-400' }} text-white px-6 py-2 rounded-full font-bold text-sm tracking-wide uppercase">
                        {{ in_array($booking->status, ['accepted', 'confirmed']) ? 'Confirmé' : 'En attente' }}
                    </span>
                </div>
                @endforeach
            @endif
        @endauth

        <!-- Barre de recherche -->
        <form action="{{ route('trips') }}" method="GET" class="bg-gradient-to-r from-[#2794EB] via-[#4BC5BC] to-[#70D78D] p-4 rounded-[2rem] mb-6 shadow-lg shadow-blue-500/10">
            <!-- Filtres de recherche (caché) -->
            @if(request('luggage')) <input type="hidden" name="luggage" value="1"> @endif
            @if(request('pets')) <input type="hidden" name="pets" value="1"> @endif
            @if(request('girl_only')) <input type="hidden" name="girl_only" value="1"> @endif

            <div class="flex flex-col lg:flex-row gap-3">
                <!-- Lieu de départ -->
                <div class="flex-1 bg-white rounded-full flex items-center px-4 py-3 relative">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="text" id="search-start" name="from" value="{{ request('from') }}" placeholder="Ex : Gare Du Nord" class="w-full outline-none focus:outline-none focus:ring-0 border-none text-gray-700 placeholder-gray-400 bg-transparent">
                    <div id="search-start-suggestions" class="absolute top-full left-0 w-full mt-1 bg-white rounded-xl shadow-lg hidden max-h-60 overflow-y-auto z-50"></div>
                </div>
                <!-- Lieu d'arrivée -->
                <div class="flex-1 bg-white rounded-full flex items-center px-4 py-3 relative">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <input type="text" id="search-end" name="to" value="{{ request('to') }}" placeholder="Ex : Campus Santé" class="w-full outline-none focus:outline-none focus:ring-0 border-none text-gray-700 placeholder-gray-400 bg-transparent">
                    <div id="search-end-suggestions" class="absolute top-full left-0 w-full mt-1 bg-white rounded-xl shadow-lg hidden max-h-60 overflow-y-auto z-50"></div>
                </div>
                <!-- Sélection de la date -->
                <div class="w-full lg:w-48 bg-white rounded-full flex items-center px-4 py-3">
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full outline-none focus:outline-none focus:ring-0 border-none text-gray-700 placeholder-gray-400 bg-transparent" placeholder="jj/mm/aaaa">
                </div>
                <!-- Sélection du nombre de passagers -->
                <div class="w-full lg:w-48 bg-white rounded-full flex items-center px-4 py-3 relative group cursor-pointer">
                    <select name="seats" class="w-full outline-none focus:outline-none focus:ring-0 border-none text-gray-700 bg-transparent appearance-none cursor-pointer z-10 box-border">
                        <option value="1" {{ request('seats') == '1' ? 'selected' : '' }}>1 passager</option>
                        <option value="2" {{ request('seats') == '2' ? 'selected' : '' }}>2 passagers</option>
                        <option value="3" {{ request('seats') == '3' ? 'selected' : '' }}>3 passagers</option>
                        <option value="4" {{ request('seats') == '4' ? 'selected' : '' }}>4 passagers</option>
                        <option value="5" {{ request('seats') == '5' ? 'selected' : '' }}>5 passagers</option>
                    </select>
                </div>
                <!-- Bouton Rechercher -->
                <button type="submit" class="bg-[#2794EB] text-white px-8 py-3 rounded-2xl font-semibold hover:bg-blue-600 transition shadow-md">
                    Rechercher
                </button>
            </div>
        </form>

        <!-- Filtres de recherche -->
        <div class="flex flex-wrap gap-4 mb-8">
            <!-- Filtre bagage -->
            <a href="{{ request()->fullUrlWithQuery(['luggage' => request('luggage') ? null : 1]) }}" 
            class="flex items-center gap-2 px-6 py-2.5 border rounded-full transition shadow-sm group {{ request('luggage') ? 'bg-blue-50 border-[#2794EB] text-[#2794EB]' : 'bg-white border-gray-200 text-gray-600 hover:border-[#2794EB] hover:text-[#2794EB]' }}">
                <svg class="w-5 h-5 transition-colors {{ request('luggage') ? 'text-[#2794EB]' : 'text-gray-600 group-hover:text-[#2794EB]' }}" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 7V6.2C8 5.0799 8 4.51984 8.21799 4.09202C8.40973 3.71569 8.71569 3.40973 9.09202 3.21799C9.51984 3 10.0799 3 11.2 3H12.8C13.9201 3 14.4802 3 14.908 3.21799C15.2843 3.40973 15.5903 3.71569 15.782 4.09202C16 4.51984 16 5.0799 16 6.2V7M7 21V7.00169M17 21V7M7 7.00169C7.24373 7 7.50929 7 7.8 7H16M7 7.00169C5.83507 7.00979 5.16873 7.05658 4.63803 7.32698C4.07354 7.6146 3.6146 8.07354 3.32698 8.63803C3 9.27976 3 10.1198 3 11.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V11.8C21 10.1198 21 9.27976 20.673 8.63803C20.3854 8.07354 19.9265 7.6146 19.362 7.32698C18.7202 7 17.8802 7 16.2 7H17M17 7H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Bagages
            </a>
            <!-- Filtre animaux -->
            <a href="{{ request()->fullUrlWithQuery(['pets' => request('pets') ? null : 1]) }}" 
            class="flex items-center gap-2 px-6 py-2.5 border rounded-full transition shadow-sm group {{ request('pets') ? 'bg-blue-50 border-[#2794EB] text-[#2794EB]' : 'bg-white border-gray-200 text-gray-600 hover:border-[#2794EB] hover:text-[#2794EB]' }}">
                <svg class="w-5 h-5 transition-colors {{ request('pets') ? 'text-[#2794EB]' : 'text-gray-600 group-hover:text-[#2794EB]' }}" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0196 14.9374C11.7284 14.9374 11.4307 14.9818 11.1784 15.0796C11.0546 15.1275 10.9032 15.2031 10.7699 15.3252C10.6361 15.4479 10.4632 15.6749 10.4632 15.9999C10.4632 16.3249 10.6361 16.5519 10.7699 16.6745C10.9032 16.7967 11.0546 16.8722 11.1784 16.9202C11.4307 17.018 11.7284 17.0624 12.0196 17.0624C12.3109 17.0624 12.6085 17.018 12.8609 16.9202C12.9846 16.8722 13.136 16.7967 13.2693 16.6745C13.4032 16.5519 13.5761 16.3249 13.5761 15.9999C13.5761 15.6749 13.4032 15.4479 13.2693 15.3252C13.136 15.2031 12.9846 15.1275 12.8609 15.0796C12.6085 14.9818 12.3109 14.9374 12.0196 14.9374Z" fill="currentColor"/>
                    <path d="M14.0365 12.6464C14.2015 12.38 14.5274 12.0625 15.0163 12.0625C15.5051 12.0625 15.831 12.38 15.996 12.6464C16.1681 12.9243 16.2501 13.2612 16.2501 13.5938C16.2501 13.9263 16.1681 14.2632 15.996 14.5411C15.831 14.8075 15.5051 15.125 15.0163 15.125C14.5274 15.125 14.2015 14.8075 14.0365 14.5411C13.8644 14.2632 13.7824 13.9263 13.7824 13.5938C13.7824 13.2612 13.8644 12.9243 14.0365 12.6464Z" fill="currentColor"/>
                    <path d="M9.01634 12.0625C8.52751 12.0625 8.20161 12.38 8.03658 12.6464C7.86445 12.9243 7.78247 13.2612 7.78247 13.5938C7.78247 13.9263 7.86445 14.2632 8.03658 14.5411C8.20161 14.8075 8.52751 15.125 9.01634 15.125C9.50518 15.125 9.83108 14.8075 9.9961 14.5411C10.1682 14.2632 10.2502 13.9263 10.2502 13.5938C10.2502 13.2612 10.1682 12.9243 9.9961 12.6464C9.83108 12.38 9.50518 12.0625 9.01634 12.0625Z" fill="currentColor"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.09485 4.25C5.48148 4.25 4.77463 4.42871 4.20882 4.91616C3.62226 5.4215 3.27004 6.18781 3.27004 7.1875V9.0625L3.27005 9.06545C3.2712 9.35941 3.3211 9.94757 3.4888 10.4392C3.54365 10.6001 3.63129 10.8134 3.77764 11.0058C3.49364 11.5688 3.35904 12.1495 3.29787 12.7095C3.2468 13.1771 3.24611 13.6679 3.25424 14.1211C2.5932 14.3507 1.90877 14.6349 1.5932 14.8387C1.24524 15.0634 1.14534 15.5277 1.37006 15.8756C1.59478 16.2236 2.05903 16.3235 2.40698 16.0988C2.5234 16.0236 2.86686 15.8664 3.31867 15.6939C3.38755 16.173 3.52716 16.6095 3.7221 17.0063C3.56621 17.1035 3.42847 17.1935 3.31889 17.2652C3.27694 17.2926 3.23912 17.3173 3.20599 17.3387C2.85803 17.5634 2.75813 18.0277 2.98285 18.3756C3.20757 18.7236 3.67182 18.8235 4.01978 18.5988C4.0609 18.5722 4.10473 18.5436 4.15098 18.5134C4.28216 18.4278 4.43287 18.3294 4.59701 18.2288C5.18653 18.8313 5.91865 19.2964 6.67916 19.6462C8.45998 20.4654 10.569 20.75 12.0001 20.75C13.4311 20.75 15.5402 20.4654 17.321 19.6462C18.0815 19.2964 18.8136 18.8313 19.4031 18.2288C19.5673 18.3294 19.718 18.4278 19.8491 18.5134C19.8954 18.5436 19.9392 18.5722 19.9803 18.5988C20.3283 18.8235 20.7925 18.7236 21.0173 18.3756C21.242 18.0277 21.1421 17.5634 20.7941 17.3387C20.761 17.3173 20.7232 17.2926 20.6812 17.2652C20.5716 17.1935 20.4339 17.1035 20.2781 17.0063C20.473 16.6095 20.6127 16.173 20.6815 15.6938C21.1335 15.8663 21.4771 16.0236 21.5936 16.0988C21.9415 16.3235 22.4058 16.2236 22.6305 15.8756C22.8552 15.5277 22.7553 15.0634 22.4074 14.8387C22.0917 14.6349 21.4071 14.3506 20.7459 14.121C20.7541 13.6678 20.7534 13.177 20.7023 12.7095C20.6412 12.1495 20.5065 11.5688 20.2225 11.0058C20.3689 10.8134 20.4565 10.6001 20.5114 10.4392C20.6791 9.94758 20.729 9.35941 20.7301 9.06545L20.7302 9.0625V7.18761C20.7302 6.18792 20.3779 5.42162 19.7914 4.91628C19.2256 4.42882 18.5187 4.25011 17.9054 4.25011C17.4969 4.25011 17.0744 4.40685 16.7337 4.56076C16.3726 4.72392 15.9952 4.9359 15.6558 5.13136C15.5828 5.17339 15.5119 5.21444 15.443 5.25432L15.441 5.25548C15.177 5.4084 14.9427 5.5441 14.7339 5.65167C14.6042 5.7185 14.5035 5.7643 14.4285 5.79206C14.3969 5.80377 14.3767 5.80966 14.3663 5.81242C14.1129 5.81102 13.9514 5.79033 13.7181 5.76044C13.6681 5.75403 13.6147 5.74719 13.5564 5.74003C13.2098 5.69743 12.7722 5.65636 12.0001 5.65636C11.228 5.65636 10.7905 5.69743 10.4438 5.74003C10.3855 5.74719 10.3322 5.75403 10.2821 5.76044C10.0489 5.79033 9.88738 5.81102 9.63388 5.81242C9.62352 5.80966 9.60332 5.80376 9.57174 5.79206C9.49678 5.7643 9.39604 5.71849 9.26633 5.65166C9.05755 5.54408 8.82331 5.40842 8.55926 5.25548C8.48975 5.21523 8.41818 5.17377 8.34446 5.13132C8.00502 4.93584 7.62764 4.72384 7.26652 4.56067C6.92587 4.40675 6.50329 4.25 6.09485 4.25ZM6.16192 17.6138C6.49595 17.8657 6.8808 18.0879 7.30604 18.2835C8.83694 18.9877 10.7179 19.25 12.0001 19.25C13.2823 19.25 15.1632 18.9877 16.6941 18.2835C17.1194 18.0879 17.5042 17.8657 17.8382 17.6138C17.4858 17.5524 17.2179 17.245 17.2179 16.875C17.2179 16.4608 17.5537 16.125 17.9679 16.125C18.2951 16.125 18.6295 16.2068 18.9399 16.3204C19.0985 15.9885 19.1959 15.625 19.2226 15.2271C18.9249 15.1544 18.7193 15.125 18.6134 15.125C18.1992 15.125 17.8634 14.7892 17.8634 14.375C17.8634 13.9608 18.1992 13.625 18.6134 13.625C18.8081 13.625 19.0284 13.6542 19.2504 13.6974C19.2505 13.4213 19.2415 13.1502 19.2112 12.8724C19.1407 12.227 18.958 11.6541 18.5269 11.1447C18.3727 10.9625 18.1809 10.7813 17.9402 10.6045C17.6063 10.3594 17.5344 9.88999 17.7796 9.55611C18.0247 9.22224 18.4941 9.15031 18.828 9.39546C18.9471 9.48292 19.0597 9.57282 19.1659 9.66506C19.2099 9.43686 19.2295 9.19817 19.2302 9.06087V7.18761C19.2302 6.56231 19.0238 6.23486 18.8123 6.0527C18.5801 5.85266 18.2496 5.75011 17.9054 5.75011C17.835 5.75011 17.659 5.78868 17.3513 5.92771C17.064 6.0575 16.7432 6.23612 16.4043 6.43125C16.3407 6.4679 16.2759 6.50544 16.2106 6.54328C15.9428 6.69843 15.666 6.85883 15.4209 6.98509C15.2663 7.06473 15.1052 7.14099 14.9495 7.19867C14.8058 7.25192 14.607 7.3125 14.3941 7.3125C14.0223 7.3125 13.7617 7.27877 13.5115 7.2464C13.4654 7.24043 13.4196 7.23449 13.3735 7.22883C13.0848 7.19336 12.7084 7.15636 12.0001 7.15636C11.2919 7.15636 10.9154 7.19336 10.6267 7.22883C10.5807 7.23449 10.5349 7.24042 10.4887 7.24639C10.2386 7.27877 9.97796 7.3125 9.6061 7.3125C9.39326 7.3125 9.19445 7.25191 9.05069 7.19866C8.89497 7.14098 8.73386 7.06471 8.57928 6.98506C8.33423 6.8588 8.05742 6.69839 7.78968 6.54325C7.72435 6.50539 7.65955 6.46784 7.59589 6.43118C7.25702 6.23603 6.93614 6.05741 6.64888 5.92761C6.34115 5.78856 6.16522 5.75 6.09485 5.75C5.75062 5.75 5.42007 5.85254 5.18787 6.05259C4.97643 6.23475 4.77004 6.56219 4.77004 7.1875V9.06088C4.7707 9.19819 4.79025 9.43686 4.83425 9.66506C4.94053 9.57281 5.05309 9.48292 5.1722 9.39546C5.50608 9.15031 5.97547 9.22224 6.22062 9.55612C6.46577 9.88999 6.39385 10.3594 6.05997 10.6045C5.81926 10.7813 5.62748 10.9625 5.47331 11.1447C5.04223 11.6541 4.85949 12.227 4.789 12.8724C4.75865 13.1502 4.74966 13.4213 4.74975 13.6975C4.97192 13.6543 5.19231 13.625 5.38719 13.625C5.80141 13.625 6.13719 13.9608 6.13719 14.375C6.13719 14.7892 5.80141 15.125 5.38719 15.125C5.28121 15.125 5.07549 15.1544 4.77758 15.2271C4.80434 15.625 4.90168 15.9885 5.06027 16.3203C5.37069 16.2068 5.70504 16.125 6.03224 16.125C6.44646 16.125 6.78224 16.4608 6.78224 16.875C6.78224 17.245 6.51433 17.5524 6.16192 17.6138Z" fill="currentColor"/>
                </svg>
                Animaux
            </a>
            <!-- Filtre fille uniquement -->
            <a href="{{ request()->fullUrlWithQuery(['girl_only' => request('girl_only') ? null : 1]) }}" 
            class="flex items-center gap-2 px-6 py-2.5 border rounded-full transition shadow-sm group {{ request('girl_only') ? 'bg-blue-50 border-[#2794EB] text-[#2794EB]' : 'bg-white border-gray-200 text-gray-600 hover:border-[#2794EB] hover:text-[#2794EB]' }}">
                <svg class="w-5 h-5 transition-colors {{ request('girl_only') ? 'text-[#2794EB]' : 'text-gray-600 group-hover:text-[#2794EB]' }}" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M433.78,491.595c-14.767-164.707-1.572-108.891-58.429-252.545v-53.747l23.347-74.059
                    c1.72-5.457,0.852-11.401-2.358-16.139c-15.205-22.442-23.071-51.435-20.037-73.862C377.824,10.003,369.071,0,357.741,0h-52.431
                    c-7.785,0-14.758,4.814-17.517,12.096c-7.523,19.854-10.712,37.552-31.791,37.552c-21.078,0-24.259-17.672-31.791-37.552
                    C221.45,4.814,214.477,0,206.692,0h-52.433c-11.343,0-20.082,10.014-18.563,21.243c3.033,22.428-4.832,51.421-20.037,73.862
                    c-3.209,4.738-4.078,10.682-2.358,16.139l23.347,74.059v53.747C79.777,382.745,92.962,327.166,78.22,491.595
                    C77.237,502.553,85.877,512,96.877,512h318.247C426.124,512,434.762,502.55,433.78,491.595z M173.624,37.463h20.134l3.423,9.034
                    C206.53,71.169,229.617,87.11,256,87.11s49.47-15.942,58.819-40.613l3.423-9.034h20.134c1.209,23.582,8.979,48.885,21.977,70.812
                    l-17.469,55.412H169.116l-17.469-55.412C164.646,86.348,172.417,61.045,173.624,37.463z M337.886,201.151v22.74H174.113v-22.74
                    H337.886z M117.353,474.537c11.93-134.582,0.694-86.685,50.76-213.182h175.775c50.037,126.424,38.832,78.582,50.76,213.182
                    H117.353z"/>
                </svg>
                Filles uniquement
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start" x-data="{ showTripModal: false, activeTrip: null }">
            <!-- Colonne de gauche -->
            <div class="space-y-6">
                <!-- Bannière pour proposer un trajet -->
                <div class="border-2 border-dashed border-[#70D78D] rounded-[2rem] p-6 flex items-center justify-between bg-white/50">
                    <div>
                        <h3 class="font-bold text-[#333333] text-lg">Vous conduisez ?</h3>
                        <p class="text-gray-500 text-sm">Partagez votre trajet et économisez.</p>
                    </div>
                    <a href="{{ route('trips.create') }}" class="bg-[#70D78D] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-green-500 transition shadow-md shadow-green-400/20 inline-block">
                        + Publier
                    </a>
                </div>

                <!-- Boucle pour chaque trajet disponible -->
                @foreach($trips as $trip)
                <div class="trip-card bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer group"
                     @dblclick="activeTrip = {{ json_encode($trip) }}; showTripModal = true"
                     data-start-lat="{{ $trip->start_lat }}"
                     data-start-long="{{ $trip->start_long }}"
                     data-end-lat="{{ $trip->end_lat }}"
                     data-end-long="{{ $trip->end_long }}"
                     data-start-address="{{ $trip->start_address }}"
                     data-end-address="{{ $trip->end_address }}">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex gap-4 relative">
                            <!-- Timeline -->
                            <div class="absolute left-[7px] top-2 bottom-2 w-0.5 bg-gray-200"></div>
                            
                            <div class="space-y-8">
                                <div class="flex items-center gap-4 relative">
                                    <div class="w-4 h-4 rounded-full border-2 border-gray-300 bg-white z-10"></div>
                                    <div>
                                        <span class="font-bold text-[#333333] text-lg">{{ $trip->start_time->format('H:i') }}</span>
                                        <p class="text-gray-400 text-sm">{{ $trip->start_address }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 relative">
                                    <div class="w-4 h-4 rounded-full border-2 border-[#70D78D] bg-white z-10"></div>
                                    <div>
                                        <span class="font-bold text-[#333333] text-lg">{{ $trip->end_time->format('H:i') }}</span>
                                        <p class="text-gray-400 text-sm">{{ $trip->end_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <span class="block text-2xl font-bold text-[#333333]">{{ number_format($trip->price, 2, ',', ' ') }}€</span>
                            <!-- Date du trajet (format français) -->
                            <span class="block text-sm text-gray-500 font-medium mb-1">{{ $trip->start_time->translatedFormat('l d F') }}</span>
                            <span class="inline-block {{ $trip->seats_available > 1 ? 'bg-[#70D78D]/20 text-[#70D78D]' : 'bg-orange-100 text-orange-500' }} text-xs font-bold px-2 py-1 rounded-md mt-1">
                                {{ $trip->seats_available }} place{{ $trip->seats_available > 1 ? 's' : '' }} restante{{ $trip->seats_available > 1 ? 's' : '' }}
                            </span>
                            
                            <!-- Icônes des options du trajet -->
                            <div class="flex gap-2 justify-end mt-2 text-gray-400">
                                <!-- Filtre bagages -->
                                @if($trip->accepts_luggage)
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" title="Bagages acceptés">
                                    <path d="M8 7V6.2C8 5.0799 8 4.51984 8.21799 4.09202C8.40973 3.71569 8.71569 3.40973 9.09202 3.21799C9.51984 3 10.0799 3 11.2 3H12.8C13.9201 3 14.4802 3 14.908 3.21799C15.2843 3.40973 15.5903 3.71569 15.782 4.09202C16 4.51984 16 5.0799 16 6.2V7M7 21V7.00169M17 21V7M7 7.00169C7.24373 7 7.50929 7 7.8 7H16M7 7.00169C5.83507 7.00979 5.16873 7.05658 4.63803 7.32698C4.07354 7.6146 3.6146 8.07354 3.32698 8.63803C3 9.27976 3 10.1198 3 11.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H16.2C17.8802 21 18.7202 21 19.362 20.673C19.9265 20.3854 20.3854 19.9265 20.673 19.362C21 18.7202 21 17.8802 21 16.2V11.8C21 10.1198 21 9.27976 20.673 8.63803C20.3854 8.07354 19.9265 7.6146 19.362 7.32698C18.7202 7 17.8802 7 16.2 7H17M17 7H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                @endif
                                
                                <!-- Filtre animaux -->
                                @if($trip->accepts_pets)
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" title="Animaux acceptés">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0196 14.9374C11.7284 14.9374 11.4307 14.9818 11.1784 15.0796C11.0546 15.1275 10.9032 15.2031 10.7699 15.3252C10.6361 15.4479 10.4632 15.6749 10.4632 15.9999C10.4632 16.3249 10.6361 16.5519 10.7699 16.6745C10.9032 16.7967 11.0546 16.8722 11.1784 16.9202C11.4307 17.018 11.7284 17.0624 12.0196 17.0624C12.3109 17.0624 12.6085 17.018 12.8609 16.9202C12.9846 16.8722 13.136 16.7967 13.2693 16.6745C13.4032 16.5519 13.5761 16.3249 13.5761 15.9999C13.5761 15.6749 13.4032 15.4479 13.2693 15.3252C13.136 15.2031 12.9846 15.1275 12.8609 15.0796C12.6085 14.9818 12.3109 14.9374 12.0196 14.9374Z" fill="currentColor"/>
                                    <path d="M14.0365 12.6464C14.2015 12.38 14.5274 12.0625 15.0163 12.0625C15.5051 12.0625 15.831 12.38 15.996 12.6464C16.1681 12.9243 16.2501 13.2612 16.2501 13.5938C16.2501 13.9263 16.1681 14.2632 15.996 14.5411C15.831 14.8075 15.5051 15.125 15.0163 15.125C14.5274 15.125 14.2015 14.8075 14.0365 14.5411C13.8644 14.2632 13.7824 13.9263 13.7824 13.5938C13.7824 13.2612 13.8644 12.9243 14.0365 12.6464Z" fill="currentColor"/>
                                    <path d="M9.01634 12.0625C8.52751 12.0625 8.20161 12.38 8.03658 12.6464C7.86445 12.9243 7.78247 13.2612 7.78247 13.5938C7.78247 13.9263 7.86445 14.2632 8.03658 14.5411C8.20161 14.8075 8.52751 15.125 9.01634 15.125C9.50518 15.125 9.83108 14.8075 9.9961 14.5411C10.1682 14.2632 10.2502 13.9263 10.2502 13.5938C10.2502 13.2612 10.1682 12.9243 9.9961 12.6464C9.83108 12.38 9.50518 12.0625 9.01634 12.0625Z" fill="currentColor"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.09485 4.25C5.48148 4.25 4.77463 4.42871 4.20882 4.91616C3.62226 5.4215 3.27004 6.18781 3.27004 7.1875V9.0625L3.27005 9.06545C3.2712 9.35941 3.3211 9.94757 3.4888 10.4392C3.54365 10.6001 3.63129 10.8134 3.77764 11.0058C3.49364 11.5688 3.35904 12.1495 3.29787 12.7095C3.2468 13.1771 3.24611 13.6679 3.25424 14.1211C2.5932 14.3507 1.90877 14.6349 1.5932 14.8387C1.24524 15.0634 1.14534 15.5277 1.37006 15.8756C1.59478 16.2236 2.05903 16.3235 2.40698 16.0988C2.5234 16.0236 2.86686 15.8664 3.31867 15.6939C3.38755 16.173 3.52716 16.6095 3.7221 17.0063C3.56621 17.1035 3.42847 17.1935 3.31889 17.2652C3.27694 17.2926 3.23912 17.3173 3.20599 17.3387C2.85803 17.5634 2.75813 18.0277 2.98285 18.3756C3.20757 18.7236 3.67182 18.8235 4.01978 18.5988C4.0609 18.5722 4.10473 18.5436 4.15098 18.5134C4.28216 18.4278 4.43287 18.3294 4.59701 18.2288C5.18653 18.8313 5.91865 19.2964 6.67916 19.6462C8.45998 20.4654 10.569 20.75 12.0001 20.75C13.4311 20.75 15.5402 20.4654 17.321 19.6462C18.0815 19.2964 18.8136 18.8313 19.4031 18.2288C19.5673 18.3294 19.718 18.4278 19.8491 18.5134C19.8954 18.5436 19.9392 18.5722 19.9803 18.5988C20.3283 18.8235 20.7925 18.7236 21.0173 18.3756C21.242 18.0277 21.1421 17.5634 20.7941 17.3387C20.761 17.3173 20.7232 17.2926 20.6812 17.2652C20.5716 17.1935 20.4339 17.1035 20.2781 17.0063C20.473 16.6095 20.6127 16.173 20.6815 15.6938C21.1335 15.8663 21.4771 16.0236 21.5936 16.0988C21.9415 16.3235 22.4058 16.2236 22.6305 15.8756C22.8552 15.5277 22.7553 15.0634 22.4074 14.8387C22.0917 14.6349 21.4071 14.3506 20.7459 14.121C20.7541 13.6678 20.7534 13.177 20.7023 12.7095C20.6412 12.1495 20.5065 11.5688 20.2225 11.0058C20.3689 10.8134 20.4565 10.6001 20.5114 10.4392C20.6791 9.94758 20.729 9.35941 20.7301 9.06545L20.7302 9.0625V7.18761C20.7302 6.18792 20.3779 5.42162 19.7914 4.91628C19.2256 4.42882 18.5187 4.25011 17.9054 4.25011C17.4969 4.25011 17.0744 4.40685 16.7337 4.56076C16.3726 4.72392 15.9952 4.9359 15.6558 5.13136C15.5828 5.17339 15.5119 5.21444 15.443 5.25432L15.441 5.25548C15.177 5.4084 14.9427 5.5441 14.7339 5.65167C14.6042 5.7185 14.5035 5.7643 14.4285 5.79206C14.3969 5.80377 14.3767 5.80966 14.3663 5.81242C14.1129 5.81102 13.9514 5.79033 13.7181 5.76044C13.6681 5.75403 13.6147 5.74719 13.5564 5.74003C13.2098 5.69743 12.7722 5.65636 12.0001 5.65636C11.228 5.65636 10.7905 5.69743 10.4438 5.74003C10.3855 5.74719 10.3322 5.75403 10.2821 5.76044C10.0489 5.79033 9.88738 5.81102 9.63388 5.81242C9.62352 5.80966 9.60332 5.80376 9.57174 5.79206C9.49678 5.7643 9.39604 5.71849 9.26633 5.65166C9.05755 5.54408 8.82331 5.40842 8.55926 5.25548C8.48975 5.21523 8.41818 5.17377 8.34446 5.13132C8.00502 4.93584 7.62764 4.72384 7.26652 4.56067C6.92587 4.40675 6.50329 4.25 6.09485 4.25ZM6.16192 17.6138C6.49595 17.8657 6.8808 18.0879 7.30604 18.2835C8.83694 18.9877 10.7179 19.25 12.0001 19.25C13.2823 19.25 15.1632 18.9877 16.6941 18.2835C17.1194 18.0879 17.5042 17.8657 17.8382 17.6138C17.4858 17.5524 17.2179 17.245 17.2179 16.875C17.2179 16.4608 17.5537 16.125 17.9679 16.125C18.2951 16.125 18.6295 16.2068 18.9399 16.3204C19.0985 15.9885 19.1959 15.625 19.2226 15.2271C18.9249 15.1544 18.7193 15.125 18.6134 15.125C18.1992 15.125 17.8634 14.7892 17.8634 14.375C17.8634 13.9608 18.1992 13.625 18.6134 13.625C18.8081 13.625 19.0284 13.6542 19.2504 13.6974C19.2505 13.4213 19.2415 13.1502 19.2112 12.8724C19.1407 12.227 18.958 11.6541 18.5269 11.1447C18.3727 10.9625 18.1809 10.7813 17.9402 10.6045C17.6063 10.3594 17.5344 9.88999 17.7796 9.55611C18.0247 9.22224 18.4941 9.15031 18.828 9.39546C18.9471 9.48292 19.0597 9.57282 19.1659 9.66506C19.2099 9.43686 19.2295 9.19817 19.2302 9.06087V7.18761C19.2302 6.56231 19.0238 6.23486 18.8123 6.0527C18.5801 5.85266 18.2496 5.75011 17.9054 5.75011C17.835 5.75011 17.659 5.78868 17.3513 5.92771C17.064 6.0575 16.7432 6.23612 16.4043 6.43125C16.3407 6.4679 16.2759 6.50544 16.2106 6.54328C15.9428 6.69843 15.666 6.85883 15.4209 6.98509C15.2663 7.06473 15.1052 7.14099 14.9495 7.19867C14.8058 7.25192 14.607 7.3125 14.3941 7.3125C14.0223 7.3125 13.7617 7.27877 13.5115 7.2464C13.4654 7.24043 13.4196 7.23449 13.3735 7.22883C13.0848 7.19336 12.7084 7.15636 12.0001 7.15636C11.2919 7.15636 10.9154 7.19336 10.6267 7.22883C10.5807 7.23449 10.5349 7.24042 10.4887 7.24639C10.2386 7.27877 9.97796 7.3125 9.6061 7.3125C9.39326 7.3125 9.19445 7.25191 9.05069 7.19866C8.89497 7.14098 8.73386 7.06471 8.57928 6.98506C8.33423 6.8588 8.05742 6.69839 7.78968 6.54325C7.72435 6.50539 7.65955 6.46784 7.59589 6.43118C7.25702 6.23603 6.93614 6.05741 6.64888 5.92761C6.34115 5.78856 6.16522 5.75 6.09485 5.75C5.75062 5.75 5.42007 5.85254 5.18787 6.05259C4.97643 6.23475 4.77004 6.56219 4.77004 7.1875V9.06088C4.7707 9.19819 4.79025 9.43686 4.83425 9.66506C4.94053 9.57281 5.05309 9.48292 5.1722 9.39546C5.50608 9.15031 5.97547 9.22224 6.22062 9.55612C6.46577 9.88999 6.39385 10.3594 6.05997 10.6045C5.81926 10.7813 5.62748 10.9625 5.47331 11.1447C5.04223 11.6541 4.85949 12.227 4.789 12.8724C4.75865 13.1502 4.74966 13.4213 4.74975 13.6975C4.97192 13.6543 5.19231 13.625 5.38719 13.625C5.80141 13.625 6.13719 13.9608 6.13719 14.375C6.13719 14.7892 5.80141 15.125 5.38719 15.125C5.28121 15.125 5.07549 15.1544 4.77758 15.2271C4.80434 15.625 4.90168 15.9885 5.06027 16.3203C5.37069 16.2068 5.70504 16.125 6.03224 16.125C6.44646 16.125 6.78224 16.4608 6.78224 16.875C6.78224 17.245 6.51433 17.5524 6.16192 17.6138Z" fill="currentColor"/>
                                </svg>
                                @endif

                                <!-- Filtre filles seulement -->
                                @if($trip->girl_only)
                                <svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg" title="Entre filles">
                                    <path d="M433.78,491.595c-14.767-164.707-1.572-108.891-58.429-252.545v-53.747l23.347-74.059
                                            c1.72-5.457,0.852-11.401-2.358-16.139c-15.205-22.442-23.071-51.435-20.037-73.862C377.824,10.003,369.071,0,357.741,0h-52.431
                                            c-7.785,0-14.758,4.814-17.517,12.096c-7.523,19.854-10.712,37.552-31.791,37.552c-21.078,0-24.259-17.672-31.791-37.552
                                            C221.45,4.814,214.477,0,206.692,0h-52.433c-11.343,0-20.082,10.014-18.563,21.243c3.033,22.428-4.832,51.421-20.037,73.862
                                            c-3.209,4.738-4.078,10.682-2.358,16.139l23.347,74.059v53.747C79.777,382.745,92.962,327.166,78.22,491.595
                                            C77.237,502.553,85.877,512,96.877,512h318.247C426.124,512,434.762,502.55,433.78,491.595z M173.624,37.463h20.134l3.423,9.034
                                            C206.53,71.169,229.617,87.11,256,87.11s49.47-15.942,58.819-40.613l3.423-9.034h20.134c1.209,23.582,8.979,48.885,21.977,70.812
                                            l-17.469,55.412H169.116l-17.469-55.412C164.646,86.348,172.417,61.045,173.624,37.463z M337.886,201.151v22.74H174.113v-22.74
                                            H337.886z M117.353,474.537c11.93-134.582,0.694-86.685,50.76-213.182h175.775c50.037,126.424,38.832,78.582,50.76,213.182
                                            H117.353z"/>
                                </svg>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <div class="flex items-center gap-3">
                            <!-- Avatar et nom du conducteur. Si pas de pp, on met la première lettre de son prénom -->
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold overflow-hidden">
                                @if($trip->driver->avatar)
                                    <img src="{{ $trip->driver->avatar }}" alt="{{ $trip->driver->first_name }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($trip->driver->first_name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <p class="font-bold text-[#333333] text-sm">{{ $trip->driver->first_name }} {{ substr($trip->driver->last_name, 0, 1) }}.</p>
                                    <!-- Icône vérifiée -->
                                    @if($trip->driver->is_verified)
                                        <svg class="w-4 h-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor" title="Étudiant vérifié">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1 text-yellow-400 text-xs">
                                    @if($trip->driver->ratings_count > 0)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-gray-500 font-medium">{{ $trip->driver->average_rating }}/5 <span class="text-gray-400">({{ $trip->driver->ratings_count }} avis)</span></span>
                                    @else
                                        <span class="text-gray-400 font-medium">0 avis</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 text-gray-400">
                                <button @click.stop="activeTrip = {{ json_encode($trip) }}; showTripModal = true" class="text-[#2794EB] hover:text-[#1a6ba3] hover:underline font-bold text-sm ml-auto">
                                    Voir plus
                                </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Colonne de droite (map) -->
            <div class="h-[600px] bg-gray-100 rounded-[2rem] overflow-hidden shadow-inner border border-gray-200 sticky top-32">
                <div id="map" class="w-full h-full z-0"></div>
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-[-1]">
                    <span class="text-gray-400">Chargement de la carte...</span>
                </div>
            </div>

            <!-- Modal détail du trajet & réservation -->
            <div x-show="showTripModal" class="fixed z-50 inset-0 overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showTripModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showTripModal = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="showTripModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                        
                        <template x-if="activeTrip">
                        <div class="bg-white" x-data="{ seats: 1 }">
                            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-0">
                                <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
                                    <h3 class="text-2xl font-bold text-[#333333]">Détail du trajet</h3>
                                    <button @click="showTripModal = false" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Colonne info trajet (Gauche) -->
                                    <div class="pb-6">
                                        <h4 class="font-bold text-[#333333] mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#2794EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Itinéraire
                                        </h4>
                                        <div class="space-y-4 relative pl-4 border-l-2 border-gray-100 ml-2">
                                            <div class="relative">
                                                <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-[#2794EB] bg-white"></div>
                                                <p class="font-bold text-lg text-gray-800" x-text="new Date(activeTrip.start_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})">08:00</p>
                                                <p class="text-gray-600" x-text="activeTrip.start_address">Depart</p>
                                            </div>
                                            <div class="relative">
                                                <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full border-2 border-[#70D78D] bg-white"></div>
                                                <p class="font-bold text-lg text-gray-800" x-text="new Date(activeTrip.end_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})">10:00</p>
                                                <p class="text-gray-600" x-text="activeTrip.end_address">Arrivée</p>
                                            </div>
                                        </div>

                                        <template x-if="activeTrip.description">
                                            <div class="mt-6 pt-4 border-t border-gray-100">
                                                <h4 class="font-bold text-[#333333] mb-2">
                                                    À propos du trajet
                                                </h4>
                                                <p class="text-gray-600 text-sm italic" x-text="activeTrip.description"></p>
                                            </div>
                                        </template>

                                        <!-- Information sur le  conducteur -->
                                        <div class="mt-6 pt-6 border-t border-gray-100">
                                            <h4 class="font-bold text-[#333333] mb-3 flex items-center justify-between">
                                                <span>Information Conducteur</span>
                                                <a :href="'/messages/' + activeTrip.driver.id + '?trip_id=' + activeTrip.id" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-full transition-colors" title="Contacter le conducteur">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                </a>
                                            </h4>
                                            <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold overflow-hidden text-xl">
                                                    <template x-if="activeTrip.driver.avatar">
                                                        <img :src="activeTrip.driver.avatar" class="w-full h-full object-cover">
                                                    </template>
                                                    <template x-if="!activeTrip.driver.avatar">
                                                        <span x-text="activeTrip.driver.first_name.charAt(0)"></span>
                                                    </template>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-1.5">
                                                        <p class="font-bold text-[#333333]" x-text="activeTrip.driver.first_name + ' ' + activeTrip.driver.last_name.charAt(0) + '.'"></p>
                                                        <template x-if="activeTrip.driver.is_verified">
                                                            <svg class="w-4 h-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor" title="Étudiant vérifié">
                                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        </template>
                                                    </div>
                                                    <template x-if="activeTrip.driver.ratings_count > 0">
                                                        <div class="flex items-center gap-1 text-yellow-500 text-xs">
                                                            <span class="font-bold" x-text="activeTrip.driver.average_rating + '/5'"></span> <span class="text-gray-400" x-text="'(' + activeTrip.driver.ratings_count + ' avis)'"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="activeTrip.driver.ratings_count == 0">
                                                        <div class="text-xs text-gray-400 font-medium">0 avis</div>
                                                    </template>
                                                </div>
                                            </div>
                                            <template x-if="activeTrip.driver.bio">
                                                <p class="text-sm text-gray-500 mt-2 italic" x-text="'&ldquo;' + activeTrip.driver.bio + '&rdquo;'"></p>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Colonne détails (droite) -->
                                    <div class="pb-6">
                                        <h4 class="font-bold text-[#333333] mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#2794EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Détails
                                        </h4>
                                        <ul class="space-y-3 text-sm text-gray-600">
                                            <li class="flex justify-between border-b border-gray-100 pb-2">
                                                <span>Véhicule</span>
                                                <span class="font-semibold text-gray-900" x-text="activeTrip.vehicle ? (activeTrip.vehicle.make + ' ' + activeTrip.vehicle.model) : 'Non spécifié'"></span>
                                            </li>
                                            <li class="flex justify-between border-b border-gray-100 pb-2">
                                                <span>Couleur</span>
                                                <span class="font-semibold text-gray-900" x-text="activeTrip.vehicle ? activeTrip.vehicle.color : '-'"></span>
                                            </li>
                                            <li class="flex justify-between border-b border-gray-100 pb-2">
                                                <span>Date</span>
                                                <span class="font-semibold text-gray-900" x-text="new Date(activeTrip.start_time).toLocaleDateString('fr-FR', {weekday: 'long', day: 'numeric', month: 'long'})"></span>
                                            </li>
                                            <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                                                <span>Options</span>
                                                <div class="flex gap-2">
                                                    <template x-if="activeTrip.accepts_luggage">
                                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded" title="Bagages autorisés">Bagages</span>
                                                    </template>
                                                    <template x-if="activeTrip.accepts_pets">
                                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded" title="Animaux acceptés">Animaux</span>
                                                    </template>
                                                    <template x-if="activeTrip.girl_only">
                                                        <span class="bg-pink-100 text-pink-800 text-xs px-2 py-0.5 rounded" title="Entre filles">Filles</span>
                                                    </template>
                                                </div>
                                            </li>
                                            <template x-if="activeTrip.distance_km && activeTrip.distance_km > 0">
                                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                                    <span>Distance</span>
                                                    <span class="font-semibold text-gray-900" x-text="activeTrip.distance_km + ' km'"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Zone de réservation -->
                            <div class="bg-gray-50 px-4 py-4 sm:px-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500" x-text="seats > 1 ? 'Prix total' : 'Prix par passager'">Prix par passager</p>
                                    <span class="text-2xl font-bold text-[#333333]" x-text="(activeTrip.price * seats).toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €'"></span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <form :action="'/trips/' + activeTrip.id + '/book'" method="POST" class="flex gap-4 items-center">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            <label class="text-sm font-medium text-gray-700">Places :</label>
                                            <select name="seats" x-model="seats" class="border border-gray-300 rounded-lg text-sm w-16 px-2 py-2 focus:ring-[#2794EB] focus:border-[#2794EB] outline-none">
                                                <template x-for="i in activeTrip.seats_available">
                                                    <option :value="i" x-text="i"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <button type="submit" class="bg-[#2794EB] hover:bg-blue-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                            <span>Réserver</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <!-- Mapbox (la map) -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    @endpush

    <script>
        // Initialisation de l'autocomplétion après le chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                if (typeof window.setupAutocomplete === 'function') {
                    window.setupAutocomplete('search-start', 'search-start-suggestions');
                    window.setupAutocomplete('search-end', 'search-end-suggestions');
                }
            }, 100);
        });
    </script>

</x-main-layout>