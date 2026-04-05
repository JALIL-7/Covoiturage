<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Contrôleurs & Comportements</title>
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
    <h1>Contrôleurs & Comportements</h1>

    <div class="section">
        <h2>TrajetController</h2>
        <ul>
            <li><span class="mono">index(Request)</span>: filtre et pagine les trajets; agrégations <span class="mono">withCount('reservations')</span> et <span class="mono">withAvg('evaluations','note')</span></li>
            <li><span class="mono">show(Trajet)</span>: renvoie la fiche trajet (ou JSON si demandé)</li>
            <li><span class="mono">store(Request)</span>: valide et crée un trajet (conducteur courant)</li>
            <li><span class="mono">edit(Trajet)</span>, <span class="mono">update(Request, Trajet)</span>, <span class="mono">destroy(Trajet)</span>: édition et suppression</li>
        </ul>
    </div>

    <div class="section">
        <h2>ReservationController</h2>
        <ul>
            <li><span class="mono">store(Request)</span>: crée une réservation si des places sont disponibles; décrémente <span class="mono">places_disponibles</span></li>
            <li><span class="mono">myReservations()</span>: affiche les réservations du passager courant</li>
            <li><span class="mono">create()</span>: liste des trajets réservables pour sélection</li>
            <li><span class="mono">reservationsForConducteur()</span>: réservations sur les trajets du conducteur courant</li>
            <li><span class="mono">destroy(Reservation)</span>: annule la réservation et ré-incrémente les places</li>
            <li><span class="mono">storeAndEvaluate(Request)</span>: transaction combinant réservation et création d’évaluation (si note fournie)</li>
        </ul>
    </div>

    <div class="section">
        <h2>EvaluationController</h2>
        <ul>
            <li><span class="mono">store(Request)</span>: valide et persiste note/commentaire pour un trajet</li>
            <li><span class="mono">index(Trajet)</span>: liste les évaluations du trajet</li>
            <li><span class="mono">evaluationsForConducteur()</span>: toutes les évaluations sur les trajets du conducteur courant</li>
        </ul>
    </div>

    <div class="section">
        <h2>VehiculeController</h2>
        <ul>
            <li><span class="mono">index(Request, $user_id)</span>: liste les véhicules d’un utilisateur (par défaut: utilisateur courant)</li>
            <li><span class="mono">show(Vehicule)</span>, <span class="mono">create()</span>, <span class="mono">update(Vehicule)</span>, <span class="mono">delete(Vehicule)</span></li>
        </ul>
    </div>

    <div class="section">
        <h2>Auth\RegisteredUserController</h2>
        <ul>
            <li><span class="mono">store(Request)</span>: inscription avec <span class="mono">role=passager</span> par défaut; login automatique</li>
        </ul>
    </div>

    <div class="section">
        <h2>Routes & Middleware</h2>
        <ul>
            <li>Routes publiques: accueil, liste/fiche des trajets</li>
            <li>Groupes protégés: <span class="mono">auth</span>, avec sous-groupes <span class="mono">role:conducteur</span> et <span class="mono">role:passager</span></li>
            <li>Dashboard: vue conducteur ou page passager selon le rôle</li>
        </ul>
    </div>
</body>
</html>
