# AmiGo 🚗

AmiGo est une plateforme de covoiturage dédiée aux étudiants d'Amiens. Elle permet de connecter facilement les étudiants véhiculés avec ceux qui cherchent un trajet pour se rendre sur leur campus, le tout de manière économique et conviviale.

## 🌟 Fonctionnalités

- **Recherche de trajets** : Trouvez facilement un conducteur pour votre destination (Gare, Campus, Centre-ville, etc.).
- **Publication de trajets** : Proposez vos places libres et partagez les frais.
- **Carte interactive** : Visualisez les conducteurs et les points d'intérêt autour de vous.
- **Tableau de bord** : Gérez vos trajets et votre profil.
- **Authentification sécurisée** : Inscription et connexion pour les étudiants.

## 🛠 Technologies utilisées

Ce projet est construit avec les technologies modernes suivantes :

- **[Laravel 12](https://laravel.com)** : Framework PHP robuste pour le backend.
- **[Tailwind CSS](https://tailwindcss.com)** : Framework CSS utilitaire pour un design moderne et réactif.
- **[Alpine.js](https://alpinejs.dev)** : Framework JavaScript léger pour l'interactivité.
- **[Vite](https://vitejs.dev)** : Outil de build rapide pour le frontend.
- **Laravel Breeze** : Starter kit pour l'authentification.

## 🚀 Installation

Suivez ces étapes pour installer et lancer le projet localement :

### Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et NPM

### Étapes

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/votre-utilisateur/amigo.git
   cd amigo
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**
   ```bash
   npm install
   ```

4. **Configurer l'environnement**
   Copiez le fichier d'exemple `.env` et générez la clé d'application :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *N'oubliez pas de configurer vos informations de base de données dans le fichier `.env`.*

5. **Exécuter les migrations**
   Créez les tables dans la base de données :
   ```bash
   php artisan migrate
   ```

6. **Lancer le serveur de développement**
   Vous aurez besoin de deux terminaux :

   *Terminal 1 (Vite pour les assets) :*
   ```bash
   npm run dev
   ```

   *Terminal 2 (Serveur Laravel) :*
   ```bash
   php artisan serve
   ```

7. **Accéder à l'application**
   Ouvrez votre navigateur et allez sur `http://localhost:8000`.

## 📝 Licence

Ce projet est sous licence [MIT](https://opensource.org/licenses/MIT).
