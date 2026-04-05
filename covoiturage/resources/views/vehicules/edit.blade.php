@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4" align="center">Modifier un véhicule</h1>

    <form method="POST" action="{{ route('vehicules.update', $vehicule->id) }}">
    @csrf
    @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Marque</label>
            <input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" class="mt-1 block w-full border rounded px-2 py-1" required />
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Modèle</label>
            <input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" class="mt-1 block w-full border rounded px-2 py-1" required />
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Immatriculation</label>
            <input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" class="mt-1 block w-full border rounded px-2 py-1" required />
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Nombre de places</label>
            <input type="number" name="nombre_places" value="{{ old('nombre_places', $vehicule->nombre_places) }}" class="mt-1 block w-full border rounded px-2 py-1" required />
        </div>
        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-black rounded">enregistrer</button>
            <a href="{{ url('/vehicules') }}" class="ml-2 text-gray-600">Annuler</a>
        </div>
    </form>
</div>
@endsection