<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Pages & Modifs Tailwind</title>
    <style>
        body { font-family: Arial, sans-serif; color:#111; font-size: 13px; line-height: 1.5; }
        h1 { font-size: 22px; margin: 0 0 10px; }
        h2 { font-size: 16px; margin: 16px 0 8px; }
        ul { margin: 6px 0 10px; padding-left: 18px; }
        .section { margin-bottom: 14px; }
        .mono { font-family: Consolas, monospace; }
    </style>
</head>
<body>
    <h1>Pages & Modifications Tailwind</h1>
    <div class="section">
        <h2>Accueil (welcome.blade)</h2>
        <ul>
            <li>Colonne de droite remplie avec “Trajets à la une” (places, prix, note moyenne) et “Mes véhicules” pour conducteurs</li>
            <li>Boutons d’action: Rechercher un trajet, Connexion, Inscription</li>
            <li>Mise en forme: cartes “glassmorphism” via Tailwind, mode sombre supporté</li>
            <li>Sources de données: <span class="mono">routes/web.php</span> sélectionne 5 trajets à venir, et 3 véhicules du conducteur connecté</li>
        </ul>
    </div>
    <div class="section">
        <h2>Liste des trajets (trajets/index.blade)</h2>
        <ul>
            <li>Affichage enrichi: badges prix, places colorisées (vert/orange/rouge), note moyenne ⭐, nombre de réservations</li>
            <li>Grille responsive: 1→2→3 colonnes selon viewport</li>
            <li>Bouton “Voir le trajet” pour accéder à la fiche détail</li>
        </ul>
    </div>
    <div class="section">
        <h2>Recherche (trajets/_search.blade)</h2>
        <ul>
            <li>Filtres: ville départ/arrivée, date, prix min/max, places min</li>
            <li>Options: inclure trajets complets, items “par page” (12/18/24/36)</li>
            <li>Bouton “Réinitialiser” pour effacer les filtres</li>
        </ul>
    </div>
    <div class="section">
        <h2>Navigation (layouts/navigation.blade)</h2>
        <ul>
            <li>Liens globaux: Dashboard, Trajets</li>
            <li>Liens par rôle:
                <ul>
                    <li>Conducteur: Véhicules, Réservations, Évaluations</li>
                    <li>Passager: Mes réservations</li>
                </ul>
            </li>
            <li>Bouton mode clair/sombre; responsive menu mis à jour</li>
        </ul>
    </div>
    <div class="section">
        <h2>Fiche trajet (trajets/show.blade)</h2>
        <ul>
            <li>Badges de métadonnées: date, heure, prix, places</li>
            <li>Bloc “Réserver et évaluer” pour passager avec note/commentaire optionnels</li>
            <li>Boutons rapides: voir évaluations, réserver seulement</li>
        </ul>
    </div>
    <div class="section">
        <h2>Style & thèmes</h2>
        <ul>
            <li>Tailwind darkMode: <span class="mono">class</span> (voir <span class="mono">tailwind.config.js</span>)</li>
            <li>Insertion du thème au chargement via <span class="mono">layouts.app</span> et bouton dans la nav</li>
            <li>Utilisation de ring, backdrop-blur, gradients pour un rendu moderne</li>
        </ul>
    </div>
</body>
</html>
