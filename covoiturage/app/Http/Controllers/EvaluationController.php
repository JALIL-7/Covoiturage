<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Trajet;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'trajet_id'   => 'required|exists:trajets,id',
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500'
        ]);

        // Vérifier que le trajet est passé
        $trajet = Trajet::findOrFail($request->trajet_id);
        if (!$trajet->date->isPast()) {
            return redirect()->back()->withErrors(['note' => 'Vous ne pouvez évaluer qu\'après la date du trajet.']);
        }

        // Vérifier que le passager a une réservation sur ce trajet
        $reserved = $trajet->reservations()->where('passager_id', Auth::id())->exists();
        if (!$reserved) {
            return redirect()->back()->withErrors(['note' => 'Vous devez avoir réservé ce trajet pour l\'évaluer.']);
        }

        // Vérifier qu'il n'a pas déjà évalué
        $alreadyEvaluated = Evaluation::where('trajet_id', $trajet->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyEvaluated) {
            return redirect()->back()->withErrors(['note' => 'Vous avez déjà évalué ce trajet.']);
        }

        Evaluation::create([
            'trajet_id'   => $request->trajet_id,
            'user_id'     => Auth::id(),
            'note'        => $request->note,
            'commentaire' => $request->commentaire,
            'date'        => now()
        ]);

        return redirect()->route('trajets.show', $request->trajet_id)
            ->with('success', 'Évaluation enregistrée avec succès !');
    }

    // List evaluations for a trajet (public)
    public function index(Trajet $trajet)
    {
        $evaluations = $trajet->evaluations()->with('user')->get();
        return view('evaluations.evaluations.index', compact('trajet', 'evaluations'));
    }

    // List evaluations for conducteur with date filter
    public function evaluationsForConducteur(Request $request)
    {
        $userId = Auth::id();

        $query = Evaluation::whereHas('trajet', function ($q) use ($userId) {
            $q->where('conducteur_id', $userId);
        })->with(['trajet', 'user']);

        if ($request->filled('date')) {
            $query->whereHas('trajet', function ($q) use ($request) {
                $q->whereDate('date', $request->date);
            });
        }

        $evaluations = $query->orderBy('date', 'desc')->get();
        $filterDate = $request->input('date', '');

        return view('evaluations.conducteur_index', compact('evaluations', 'filterDate'));
    }
}
