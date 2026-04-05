<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trajet;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Auth;

class TrajetController extends Controller
{
    // Lister les trajets — uniquement ceux dont la date est aujourd'hui ou dans le futur
    public function index(Request $request)
    {
        // Exclure automatiquement les trajets dont la date est passée
        $query = Trajet::query()->whereDate('date', '>=', now()->toDateString());

        // Par défaut : uniquement les trajets avec des places disponibles
        if (!$request->boolean('all')) {
            $query->where('places_disponibles', '>', 0);
        }

        // Filtres de recherche
        $villeDepart  = trim((string) $request->input('ville_depart', ''));
        $villeArrivee = trim((string) $request->input('ville_arrivee', ''));

        if ($villeDepart !== '') {
            $query->where('ville_depart', 'like', '%' . $villeDepart . '%');
        }

        if ($villeArrivee !== '') {
            $query->where('ville_arrivee', 'like', '%' . $villeArrivee . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $trajets = $query
            ->withCount(['reservations'])
            ->withAvg('evaluations', 'note')
            ->orderBy('date')
            ->paginate(12)
            ->withQueryString();

        return view('trajets.index', [
            'trajets' => $trajets,
            'filters' => $request->only(['ville_depart', 'ville_arrivee', 'date']),
        ]);
    }

    // Afficher un trajet
    public function show(Trajet $trajet)
    {
        $trajet->load(['reservations', 'evaluations.user', 'conducteur', 'vehicule']);
        return view('trajets.show', compact('trajet'));
    }

    // Formulaire de création
    public function create()
    {
        $vehicules = Vehicule::where('user_id', Auth::id())->get();
        return view('trajets.create', compact('vehicules'));
    }

    // Publier un trajet
    public function store(Request $request)
    {
        $request->validate([
            'ville_depart'       => 'required',
            'ville_arrivee'      => 'required',
            'date'               => 'required|date|after_or_equal:today',
            'heure'              => 'required',
            'prix'               => 'required|integer|min:0',
            'places_disponibles' => 'required|integer|min:1|max:6',
            'vehicule_id'        => 'nullable|exists:vehicules,id',
        ]);

        $data                 = $request->only(['ville_depart', 'ville_arrivee', 'date', 'heure', 'prix', 'places_disponibles', 'vehicule_id']);
        $data['conducteur_id'] = Auth::id();

        Trajet::create($data);

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet publié avec succès');
    }

    // Formulaire de modification
    public function edit(Trajet $trajet)
    {
        $vehicules = Vehicule::where('user_id', Auth::id())->get();
        return view('trajets.edit', compact('trajet', 'vehicules'));
    }

    // Modifier un trajet
    public function update(Request $request, Trajet $trajet)
    {
        $request->validate([
            'ville_depart'       => 'required',
            'ville_arrivee'      => 'required',
            'date'               => 'required|date',
            'heure'              => 'required',
            'prix'               => 'required|integer|min:0',
            'places_disponibles' => 'required|integer|min:1|max:6',
            'vehicule_id'        => 'nullable|exists:vehicules,id',
        ]);

        $trajet->update($request->only(['ville_depart', 'ville_arrivee', 'date', 'heure', 'prix', 'places_disponibles', 'vehicule_id']));

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet modifié avec succès');
    }

    // Supprimer un trajet
    public function destroy(Trajet $trajet)
    {
        $trajet->delete();

        return redirect()->route('trajets.index')
            ->with('success', 'Trajet supprimé avec succès');
    }
}
