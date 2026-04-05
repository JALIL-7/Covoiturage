<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Documentation Projet Covoiturage</title>
    <style>
        body { font-family: Arial, sans-serif; color:#111; font-size: 13px; line-height: 1.5; }
        h1 { font-size: 22px; margin: 0 0 10px; }
        h2 { font-size: 16px; margin: 16px 0 8px; }
        ul { margin: 6px 0 10px; padding-left: 18px; }
        .section { margin-bottom: 14px; }
        .muted { color: #555; }
        .mono { font-family: Consolas, monospace; }
    </style>
</head>
<body>
    <h1>Projet: Système de Covoiturage Universitaire</h1>
    <div class="muted">Résumé technique et fonctionnel</div>

    <div class="section">
        <h2>Stack technique</h2>
        <ul>
            <li>Backend: Laravel 12 (PHP 8.2)</li>
            <li>Frontend: Blade + Vite</li>
            <li>UI: TailwindCSS, AlpineJS</li>
            <li>Dark Mode via classe <span class="mono">dark</span></li>
        </ul>
    </div>

    <div class="section">
        <h2>Fonctionnalités principales</h2>
        <ul>
            <li>Publication de trajets par les conducteurs</li>
            <li>Recherche de trajets avec filtres (villes, date, prix, places, pagination)</li>
            <li>Réservation de place (décrément des places disponibles)</li>
            <li>Évaluation des trajets (note + commentaire)</li>
            <li>Gestion des véhicules côté conducteur</li>
            <li>Pages dédiées Passager vs Conducteur (navigation conditionnelle)</li>
        </ul>
    </div>

    <div class="section">
        <h2>Modèles de données (simplifiés)</h2>
        <ul>
            <li>Utilisateur: rôles <span class="mono">passager</span> ou <span class="mono">conducteur</span></li>
            <li>Trajet: villes, date, heure, prix, places_disponibles, relations évaluations et réservations</li>
            <li>Réservation: trajet_id, passager_id, date_reservation, statut</li>
            <li>Évaluation: trajet_id, user_id, note, commentaire, date</li>
            <li>Véhicule: user_id, marque, modèle, immatriculation, nombre_places</li>
        </ul>
    </div>

    <div class="section">
        <h2>Pages clés</h2>
        <ul>
            <li>Accueil: “Trajets à la une” et “Mes véhicules” (si conducteur)</li>
            <li>Trajets: liste + fiches détaillées; recherche avancée</li>
            <li>Réservations: vues passager et conducteur</li>
            <li>Évaluations: par trajet et globales pour le conducteur</li>
            <li>Profil: mise à jour des infos et mot de passe</li>
        </ul>
    </div>

    <div class="section">
        <h2>Points d’architecture</h2>
        <ul>
            <li>Séparation logique contrôleurs: Trajets, Réservations, Évaluations, Véhicules</li>
            <li>Middleware <span class="mono">role</span> pour restreindre routes conducteurs/passagers</li>
            <li>Requêtes paginées et agrégations (count réservations, avg note)</li>
            <li>Vite pour assets et Tailwind pour le design moderne</li>
        </ul>
    </div>

    <div class="section">
        <h2>Améliorations récentes</h2>
        <ul>
            <li>Formulaire de recherche enrichi (date, prix min/max, places, per_page, “Inclure complets”)</li>
            <li>Cartes trajets avec note moyenne et nombre de réservations</li>
            <li>Navigation conditionnelle selon rôle</li>
            <li>Accueil: remplissage des cartes avec trajets à la une et véhicules</li>
        </ul>
    </div>
</body>
</html>
