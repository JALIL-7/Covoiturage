<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Trajet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    // Réserver une place (passager)
    public function store(Request $request)
    {
        $request->validate([
            'trajet_id' => 'required|exists:trajets,id',
        ]);

        $trajet = Trajet::findOrFail($request->trajet_id);

        if ($trajet->places_disponibles <= 0) {
            return redirect()->back()->withErrors(['trajet' => 'Plus de places disponibles']);
        }

        // Empêcher de réserver deux fois le même trajet
        $exists = Reservation::where('trajet_id', $trajet->id)
            ->where('passager_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['trajet' => 'Vous avez déjà réservé ce trajet']);
        }

        Reservation::create([
            'trajet_id'        => $trajet->id,
            'passager_id'      => Auth::id(),
            'date_reservation' => now(),
            'statut'           => 'confirmee'
        ]);

        $trajet->decrement('places_disponibles');

        return redirect()->route('reservations.index')
            ->with('success', 'Réservation effectuée avec succès');
    }

    // Show current authenticated user's reservations (avec filtre date)
    public function myReservations(Request $request)
    {
        $query = Reservation::where('passager_id', Auth::id())->with('trajet');

        if ($request->filled('date')) {
            $query->whereHas('trajet', function ($q) use ($request) {
                $q->whereDate('date', $request->date);
            });
        }

        $reservations = $query->orderBy('created_at', 'desc')->get();

        return view('reservations.index', compact('reservations'));
    }

    // Show create form for passenger to add a reservation
    public function create(Request $request)
    {
        $trajetId = (int) $request->input('trajet_id');
        $trajet = $trajetId ? Trajet::where('places_disponibles', '>', 0)->find($trajetId) : null;

        $trajets = Trajet::where('places_disponibles', '>', 0)
            ->orderBy('date')
            ->get();

        return view('reservations.create', compact('trajets', 'trajet'));
    }

    // Réservations d'un trajet spécifique (côté conducteur)
    public function reservationsForTrajet(Trajet $trajet)
    {
        // Vérifier que le conducteur est bien le propriétaire
        if ($trajet->conducteur_id !== Auth::id()) {
            abort(403, 'Accès refusé.');
        }

        $reservations = $trajet->reservations()->with('passager')->get();

        return view('reservations.conducteur_trajet', compact('trajet', 'reservations'));
    }

    // Toutes les réservations d'un conducteur (menu navbar)
    public function reservationsForConducteur()
    {
        $reservations = Reservation::whereHas('trajet', function ($q) {
            $q->where('conducteur_id', Auth::id());
        })->with(['trajet', 'passager'])->orderBy('created_at', 'desc')->get();

        return view('reservations.conducteur_index', compact('reservations'));
    }

    // Annuler et supprimer une réservation
    public function destroy(Reservation $reservation)
    {
        $trajet = $reservation->trajet;
        if ($trajet) {
            $trajet->increment('places_disponibles');
        }

        $reservation->delete();

        // Rediriger selon le rôle
        $role = Auth::user()->role ?? 'passager';
        if ($role === 'passager') {
            return redirect()->route('reservations.index')
                ->with('success', 'Réservation annulée et supprimée avec succès');
        }

        return redirect()->back()->with('success', 'Réservation supprimée avec succès');
    }

    // Réserver uniquement (séparé de l'évaluation)
    public function storeAndEvaluate(Request $request)
    {
        // Cet endpoint n'est plus utilisé — garder pour compatibilité
        return $this->store($request);
    }
}
