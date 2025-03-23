# ReserveUnToit - Application de réservation immobilière

## À propos
ReserveUnToit est une application web de réservation immobilière développée avec Laravel 11, Livewire, Filament et TailwindCSS. Elle permet aux utilisateurs de parcourir des propriétés, d'effectuer des réservations et aux administrateurs de gérer l'ensemble via un panneau d'administration.

## Fonctionnalités
- **Authentification complète** (inscription, connexion, gestion de profil)
- **Catalogue de propriétés** avec recherche et filtrage
- **Système de réservation** interactif avec validation en temps réel
- **Tableau de bord utilisateur** pour suivre ses réservations
- **Interface d'administration** pour la gestion des propriétés et réservations
- **Statistiques et graphiques** pour suivre l'activité de la plateforme

## Technologies utilisées
- Laravel 11
- Livewire
- Filament Admin Panel
- TailwindCSS
- MySQL

## Installation
1. Cloner le dépôt: `git clone https://github.com/votre-nom/reserveuntoit.git`
2. Installer les dépendances: `composer install && npm install`
3. Copier le fichier d'environnement: `cp .env.example .env`
4. Configurer la base de données dans le fichier `.env`
5. Générer la clé d'application: `php artisan key:generate`
6. Exécuter les migrations avec les seeders: `php artisan migrate --seed`
7. Compiler les assets: `npm run dev`
8. Démarrer le serveur: `php artisan serve`

## Structure du projet
- **Controllers**: Gestion des requêtes HTTP
- **Models**: Modèles Eloquent avec relations
- **Livewire Components**: Composants interactifs pour la réservation et la recherche
- **Filament Resources**: Configuration de l'interface d'administration
- **Views**: Templates Blade avec composants réutilisables

## Utilisation
### Utilisateurs
- Créer un compte ou se connecter
- Parcourir les propriétés disponibles
- Consulter les détails d'une propriété
- Effectuer une réservation en sélectionnant les dates
- Consulter et gérer ses réservations depuis son profil

### Administrateurs
- Accéder au panneau d'administration via `/admin`
- Gérer les propriétés (ajout, modification, suppression)
- Consulter et gérer les réservations
- Visualiser les statistiques et tendances

## Captures d'écran
[Inclure ici les captures d'écran des principales pages de votre application]

## Informations de développement
- **Développeur**: CND - Web Is Yours
- **Contact**: cndweb37@gmail.com
- **Date de réalisation**: 19 Mars 2025
