<x-main-layout>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h1 class="text-3xl font-bold mb-8 text-gray-900 border-b pb-4">Mentions Légales</h1>

        <div class="space-y-8 text-gray-700">
            <!-- Editeur du site -->
            <section class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-[#2794EB] flex items-center">
                    <span class="bg-[#2794EB]/10 p-2 rounded mr-3">1</span>
                    Éditeur du site
                </h2>
                <div class="pl-0 md:pl-12">
                    <p class="mb-2">Le site <strong>AmiGo</strong> est une plateforme de covoiturage universitaire.</p>
                    <ul class="list-disc ml-5 space-y-1">
                        <li><strong>Dénomination sociale :</strong> AmiGo Association</li>
                        <li><strong>Siège social :</strong> IUT Amiens, Avenue des Facultés, Le Bailly, 80025 Amiens</li>
                        <li><strong>Email :</strong> contact@amigo.fr</li>
                        <li><strong>Téléphone :</strong> 06 12 34 56 78</li>
                        <li><strong>Directeur de la publication :</strong> CHARLES Lenny, PREVOST Mathis, D'AMICO-KARST Tilio </li>
                    </ul>
                </div>
            </section>

            <!-- Hébergement -->
            <section class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-[#2794EB] flex items-center">
                    <span class="bg-[#2794EB]/10 p-2 rounded mr-3">2</span>
                    Hébergement
                </h2>
                <div class="pl-0 md:pl-12">
                    <p>Ce site est hébergé par :</p>
                    <p class="mt-2 text-sm text-gray-600">
                        Hébergement local
                    </p>
                </div>
            </section>

             <!-- Propriété intellectuelle -->
             <section class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-[#2794EB] flex items-center">
                    <span class="bg-[#2794EB]/10 p-2 rounded mr-3">3</span>
                    Propriété intellectuelle
                </h2>
                <div class="pl-0 md:pl-12">
                    <p>
                        L'ensemble des contenus (textes, images, base de données) présents sur AmiGo est protégé par le droit d'auteur.
                        Toute reproduction ou représentation, totale ou partielle, sans l'accord de l'éditeur est interdite.
                    </p>
                </div>
            </section>

             <!-- Données personnelles et Cookies -->
            <section class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-xl font-semibold mb-4 text-[#2794EB] flex items-center">
                    <span class="bg-[#2794EB]/10 p-2 rounded mr-3">4</span>
                    Données personnelles et Cookies
                </h2>
                <div class="pl-0 md:pl-12">
                    <p class="mb-4">
                        AmiGo s'engage à protéger la vie privée de ses utilisateurs conformément au RGPD.
                    </p>
                    <p>
                        Pour plus d'informations sur la collecte et le traitement de vos données, ainsi que sur l'utilisation des cookies,
                        veuillez consulter notre <a href="{{ route('legal.privacy') }}" class="text-[#2794EB] hover:underline">Politique de Confidentialité</a>.
                    </p>
                </div>
            </section>
        </div>
    </div>
</x-main-layout>
