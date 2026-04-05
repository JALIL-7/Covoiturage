<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trajet;
use App\Models\Reservation;
use App\Models\Vehicule;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'        => User::count(),
            'trajets'      => Trajet::count(),
            'reservations' => Reservation::count(),
            'vehicules'    => Vehicule::count(),
            'evaluations'  => Evaluation::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => ['required', 'in:passager,conducteur,admin'],
        ]);

        $oldRole = $user->role;
        $newRole = $data['role'];

        if ($oldRole !== $newRole) {
            // Supprimer les données liées à l'ancien rôle
            if ($oldRole === 'conducteur') {
                // Supprimer les trajets du conducteur et leurs réservations/évaluations
                $trajetIds = Trajet::where('conducteur_id', $user->id)->pluck('id');
                Reservation::whereIn('trajet_id', $trajetIds)->each(function ($r) {
                    // Remettre les places disponibles
                    if ($r->trajet) {
                        $r->trajet->increment('places_disponibles');
                    }
                });
                Evaluation::whereIn('trajet_id', $trajetIds)->delete();
                Reservation::whereIn('trajet_id', $trajetIds)->delete();
                Trajet::whereIn('id', $trajetIds)->delete();

                // Supprimer ses véhicules
                Vehicule::where('user_id', $user->id)->delete();
            }

            if ($oldRole === 'passager') {
                // Supprimer ses réservations et ses évaluations
                $reservations = Reservation::where('passager_id', $user->id)->with('trajet')->get();
                foreach ($reservations as $r) {
                    if ($r->trajet) {
                        $r->trajet->increment('places_disponibles');
                    }
                }
                Reservation::where('passager_id', $user->id)->delete();
                Evaluation::where('user_id', $user->id)->delete();
            }

            $user->update(['role' => $newRole]);
        }

        return back()->with('success', "Rôle mis à jour. Les données de l'ancien rôle ont été supprimées.");
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $data = $request->validate([
            'status' => ['required', 'in:active,suspendu'],
        ]);
        $user->update(['status' => $data['status']]);
        return back()->with('success', 'Statut mis à jour');
    }

    public function trajets()
    {
        $trajets = Trajet::withCount(['reservations'])->withAvg('evaluations', 'note')->orderBy('date', 'desc')->get();
        return view('admin.trajets.index', compact('trajets'));
    }

    public function deleteTrajet(Trajet $trajet)
    {
        // Remettre les places des réservations avant suppression
        foreach ($trajet->reservations as $r) {
            // Pas besoin ici car le trajet est supprimé
        }
        $trajet->delete();
        return back()->with('success', 'Trajet supprimé');
    }

    public function reservations()
    {
        $reservations = Reservation::with(['trajet', 'passager'])->orderBy('created_at', 'desc')->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function deleteReservation(Reservation $reservation)
    {
        $trajet = $reservation->trajet;
        if ($trajet) {
            $trajet->increment('places_disponibles');
        }
        $reservation->delete();
        return back()->with('success', 'Réservation supprimée et places mises à jour');
    }

    public function vehicules()
    {
        $vehicules = Vehicule::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.vehicules.index', compact('vehicules'));
    }

    public function deleteVehicule(Vehicule $vehicule)
    {
        $vehicule->delete();
        return back()->with('success', 'Véhicule supprimé');
    }

    public function evaluations()
    {
        $evaluations = Evaluation::with(['trajet', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.evaluations.index', compact('evaluations'));
    }

    public function deleteEvaluation(Evaluation $evaluation)
    {
        $evaluation->delete();
        return back()->with('success', 'Évaluation supprimée');
    }
}
