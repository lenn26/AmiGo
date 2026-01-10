<x-main-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <form method="post" action="{{ route('profile.update') }}" class="p-4 sm:p-8 bg-white shadow rounded-xl" enctype="multipart/form-data">
                @csrf
                @method('patch')
                
                <!-- Header du profil -->
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-6xl font-bold text-[#333333]">Mon profil</h1>
                        <p class="mt-2 text-sm text-[#333333]/80">Gère tes informations personnelles et ton véhicule pour
                            <span class="block">covoiturer sereinement.</span>
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-4xl mb-2 overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Profile Photo" class="w-full h-full object-cover">
                            @else
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <button type="button" class="text-blue-500 text-sm hover:underline">Modifier photo</button>
                    </div>
                </div>

                <!-- Section : Mes informations -->
                <div class="mb-8 border-b pb-8">
                    <h2 class="text-lg font-medium text-blue-500 mb-4">Mes informations</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Prénom -->
                        <div>
                            <x-input-label for="first_name" :value="__('Prénom')" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full bg-gray-50" :value="old('first_name', $user->first_name)" required autofocus autocomplete="given-name" placeholder="Ton prénom" />
                            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                        </div>

                        <!-- Nom -->
                        <div>
                            <x-input-label for="last_name" :value="__('Nom')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full bg-gray-50" :value="old('last_name', $user->last_name)" required autocomplete="family-name" placeholder="Ton nom" />
                            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email universitaire')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-100 text-gray-500 cursor-not-allowed" :value="old('email', $user->email)" readonly title="Non modifiable" />
                            <p class="text-xs text-gray-400 mt-1">(Non modifiable)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <x-input-label for="phone" :value="__('Téléphone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full bg-gray-50" :value="old('phone', $user->phone)" placeholder="Ton numéro de téléphone" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="mt-6">
                        <x-input-label for="bio" :value="__('Ma bio (Visible par les autres étudiants)')" />
                        <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50" placeholder="Bio">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>
                </div>

                <!-- Section : Mes véhicules -->
                <div class="mb-8 border-b pb-8" x-data="{ showModal: false }">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-medium text-blue-500">Mes véhicules</h2>
                    </div>
                
                    <div class="space-y-4 mb-6">
                        @forelse($vehicles as $v)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <div>
                                    <h3 class="font-bold text-gray-800">{{ $v->make }} {{ $v->model }}</h3>
                                    <p class="text-sm text-gray-500">{{ $v->color }} • {{ $v->license_plate }} • {{ $v->seats_total }} place{{ $v->seats_total > 1 ? 's' : '' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                        @click="$dispatch('open-edit-vehicle-modal', { 
                                            url: '{{ route('vehicles.update', $v->id) }}',
                                            make: '{{ addslashes($v->make) }}',
                                            model: '{{ addslashes($v->model) }}',
                                            license_plate: '{{ addslashes($v->license_plate) }}',
                                            color: '{{ addslashes($v->color) }}',
                                            seats: '{{ $v->seats_total }}'
                                        })"
                                        class="text-blue-500 hover:bg-blue-50 p-2 rounded-lg transition-colors" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>

                                    <button type="button" @click="$dispatch('open-delete-modal', { url: '{{ route('vehicles.destroy', $v->id) }}' })" 
                                        class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-center py-4">Aucun véhicule enregistré.</p>
                        @endforelse
                    </div>

                    <!-- Bouton ajouter un véhicule  -->
                    <button type="button" @click="$dispatch('open-add-vehicle-modal')" class="w-full border-2 border-dashed border-blue-400 text-blue-500 font-medium py-3 rounded-lg hover:bg-blue-50 transition-colors">
                        + Ajouter un autre véhicule
                    </button>
                </div>

                <!-- Section Sécurité -->
                <div class="mb-8 border-b pb-8">
                    <h2 class="text-lg font-medium text-blue-500 mb-4">Sécurité</h2>
                    <div>
                        <x-input-label for="password" :value="__('Nouveau mot de passe')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-md bg-gray-50" autocomplete="new-password" placeholder="Laisser vide si inchangé" />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-md bg-gray-50" autocomplete="new-password" placeholder="Confirmer le mot de passe" />
                             <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>

                <!-- Bouton enregistrer -->
                <div class="flex items-center gap-4">
                    <button type="submit" class="w-full justify-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg shadow transition-colors">
                        Enregistrer les modifications
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 absolute ml-4"
                            style="margin-left: 100%; width: max-content;"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>

            </form>

            <!-- Popup ajout d'un véhicule -->
            <div x-data="{ show: false }" 
                 x-show="show" 
                 @open-add-vehicle-modal.window="show = true"
                 @keydown.escape.window="show = false"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" @click.stop>
                        <form action="{{ route('vehicles.store') }}" method="POST" class="p-6">
                            @csrf
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Ajouter un nouveau véhicule
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="new_make" :value="__('Marque')" />
                                    <x-text-input id="new_make" name="make" type="text" class="mt-1 block w-full bg-gray-50" placeholder="ex: Peugeot" required />
                                </div>
                                <div>
                                    <x-input-label for="new_model" :value="__('Modèle')" />
                                    <x-text-input id="new_model" name="model" type="text" class="mt-1 block w-full bg-gray-50" placeholder="ex: 208" required />
                                </div>
                                <div>
                                    <x-input-label for="new_license_plate" :value="__('Immatriculation')" />
                                    <x-text-input id="new_license_plate" name="license_plate" type="text" class="mt-1 block w-full bg-gray-50" placeholder="AB-123-CD" required />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="new_color" :value="__('Couleur')" />
                                        <x-text-input id="new_color" name="color" type="text" class="mt-1 block w-full bg-gray-50" placeholder="Rouge" />
                                    </div>
                                    <div>
                                        <x-input-label for="new_seats" :value="__('Places')" />
                                        <x-text-input id="new_seats" name="seats_total" type="number" class="mt-1 block w-full bg-gray-50" placeholder="4" required min="1" max="10" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Ajouter
                                </button>
                                <button type="button" @click="show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Popup modification d'un véhicule -->
            <div x-data="{ show: false, url: '', form: { make: '', model: '', license_plate: '', color: '', seats: '' } }" 
                 x-show="show" 
                 @open-edit-vehicle-modal.window="
                    show = true;
                    url = $event.detail.url;
                    form.make = $event.detail.make;
                    form.model = $event.detail.model;
                    form.license_plate = $event.detail.license_plate;
                    form.color = $event.detail.color;
                    form.seats = $event.detail.seats;
                 "
                 @keydown.escape.window="show = false"
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" @click.stop>
                        <form :action="url" method="POST" class="p-6">
                            @csrf
                            @method('PATCH')
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Modifier le véhicule
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="edit_make" :value="__('Marque')" />
                                    <x-text-input id="edit_make" name="make" x-model="form.make" type="text" class="mt-1 block w-full bg-gray-50" required />
                                </div>
                                <div>
                                    <x-input-label for="edit_model" :value="__('Modèle')" />
                                    <x-text-input id="edit_model" name="model" x-model="form.model" type="text" class="mt-1 block w-full bg-gray-50" required />
                                </div>
                                <div>
                                    <x-input-label for="edit_license_plate" :value="__('Immatriculation')" />
                                    <x-text-input id="edit_license_plate" name="license_plate" x-model="form.license_plate" type="text" class="mt-1 block w-full bg-gray-50" required />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="edit_color" :value="__('Couleur')" />
                                        <x-text-input id="edit_color" name="color" x-model="form.color" type="text" class="mt-1 block w-full bg-gray-50" />
                                    </div>
                                    <div>
                                        <x-input-label for="edit_seats" :value="__('Places')" />
                                        <x-text-input id="edit_seats" name="seats_total" x-model="form.seats" type="number" class="mt-1 block w-full bg-gray-50" required min="1" max="10" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Enregistrer
                                </button>
                                <button type="button" @click="show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Popup suppression d'un véhicule -->
            <div x-data="{ show: false, url: '' }"
                 @open-delete-modal.window="show = true; url = $event.detail.url" 
                 x-show="show"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">
                 
                 <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white p-5 sm:p-6">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Supprimer le véhicule
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Êtes-vous sûr de vouloir supprimer ce véhicule ? Cette action est irréversible.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <form :action="url" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Supprimer
                                </button>
                            </form>
                            <button type="button" @click="show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-main-layout>
