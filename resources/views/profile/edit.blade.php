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

                <!-- Section : Mon véhicule -->
                <div class="mb-8 border-b pb-8">
                    <h2 class="text-lg font-medium text-blue-500 mb-4">Mon véhicule</h2>
                    
                    <div class="border rounded-lg p-6 relative bg-white border-gray-200 border-dashed">
                        <!-- Badge Principal -->
                        <div class="absolute -top-3 right-4 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                            Principal
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Marque -->
                            <div>
                                <x-input-label for="make" :value="__('Marque')" />
                                <x-text-input id="make" name="make" type="text" class="mt-1 block w-full bg-gray-50" :value="old('make', $vehicle->make ?? '')" placeholder="Marque du véhicule" />
                            </div>

                            <!-- Modèle -->
                            <div>
                                <x-input-label for="model" :value="__('Modèle')" />
                                <x-text-input id="model" name="model" type="text" class="mt-1 block w-full bg-gray-50" :value="old('model', $vehicle->model ?? '')" placeholder="Modèle de la voiture" />
                            </div>

                            <!-- Immatriculation -->
                            <div>
                                <x-input-label for="license_plate" :value="__('Immatriculation')" />
                                <x-text-input id="license_plate" name="license_plate" type="text" class="mt-1 block w-full bg-gray-50" :value="old('license_plate', $vehicle->license_plate ?? '')" placeholder="Plaque d'immatriculation" />
                            </div>
                            
                            <!-- Couleur -->
                            <div>
                                <x-input-label for="color" :value="__('Couleur')" />
                                <x-text-input id="color" name="color" type="text" class="mt-1 block w-full bg-gray-50" :value="old('color', $vehicle->color ?? '')" placeholder="Couleur du véhicule" />
                            </div>

                            <!-- Places -->
                            <div class="md:col-span-2">
                                <x-input-label for="seats_total" :value="__('Places')" />
                                <x-text-input id="seats_total" name="seats_total" type="number" class="mt-1 block w-full bg-gray-50" :value="old('seats_total', $vehicle->seats_total ?? '')" placeholder="Nombre de places dans le véhicule" />
                            </div>
                        </div>
                    </div>

                    <!-- Bouton ajouter un véhicule -->
                    <button type="button" class="mt-4 w-full border-2 border-dashed border-blue-400 text-blue-500 font-medium py-3 rounded-lg hover:bg-blue-50 transition-colors">
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
        </div>
    </div>
</x-main-layout>
