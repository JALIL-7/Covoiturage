<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'marque'        => 'required',
            'modele'        => 'required',
            'immatriculation' => 'required',
            'nombre_places' => 'required|integer|min:1|max:6',
        ]);

        $data = $request->only(['marque','modele','immatriculation','nombre_places']);
        $data['user_id'] = auth()->id();

        Vehicule::create($data);

        return redirect()->route('vehicules.index')
            ->with('success', 'Véhicule ajouté avec succès');
    }

    public function index(Request $request, $user_id = null)
    {
        $user_id = $user_id ?? Auth::id();
        $vehicules = Vehicule::where('user_id', $user_id)->get();

        if ($request->wantsJson()) {
            return response()->json($vehicules);
        }

        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        return view('vehicules.create');
    }
    public function show(Vehicule $vehicule, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json($vehicule);
        }

        return view('vehicules.show', compact('vehicule'));
      
    }
    public function edit(Vehicule $vehicule)
    {
    return view('vehicules.edit', compact('vehicule'));
    }


     public function update(Request $request, Vehicule $vehicule)
    {
        $vehicule->update($request->all());

       return redirect()->route('vehicules.index')
        ->with('success', 'Véhicule modifié avec succès');
    }
    public function delete(Request $request, Vehicule $vehicule)
    {
        $vehicule->delete();

        return redirect()->route('vehicules.index')
        ->with('success', 'Véhicule supprimé avec succès'); 
    }
}
