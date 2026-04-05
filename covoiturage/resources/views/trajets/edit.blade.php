@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Modifier le trajet</span>
        </h1>
    </div>

    @if($errors->any())
    <div class="mb-4 rounded-xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-700 p-4">
        <ul class="text-sm text-rose-700 dark:text-rose-300 space-y-1">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ url('/trajets/'.$trajet->id) }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label value="Ville départ" />
                <x-text-input type="text" name="ville_depart" value="{{ old('ville_depart', $trajet->ville_depart) }}" class="mt-1 w-full" required />
            </div>
            <div>
                <x-input-label value="Ville arrivée" />
                <x-text-input type="text" name="ville_arrivee" value="{{ old('ville_arrivee', $trajet->ville_arrivee) }}" class="mt-1 w-full" required />
            </div>
            <div>
                <x-input-label value="Date" />
                <x-text-input type="date" name="date" value="{{ old('date', $trajet->date->format('Y-m-d')) }}" class="mt-1 w-full" required />
            </div>
            <div>
                <x-input-label value="Heure" />
                <x-text-input type="time" name="heure" value="{{ old('heure', $trajet->heure) }}" class="mt-1 w-full" required />
            </div>
            <div>
                <x-input-label value="Prix (FCFA)" />
                <x-text-input type="number" name="prix" value="{{ old('prix', $trajet->prix) }}" class="mt-1 w-full" required min="0" />
            </div>
            <div>
                <x-input-label value="Places disponibles (max 6)" />
                <x-text-input type="number" name="places_disponibles" value="{{ old('places_disponibles', $trajet->places_disponibles) }}" class="mt-1 w-full" required min="1" max="6" />
            </div>
        </div>

        {{-- Sélection du véhicule --}}
        <div class="mt-4">
            <x-input-label value="Véhicule utilisé (optionnel)" />
            @if($vehicules->count())
                <select name="vehicule_id" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    <option value="">-- Aucun véhicule sélectionné --</option>
                    @foreach($vehicules as $v)
                        <option value="{{ $v->id }}" @selected(old('vehicule_id', $trajet->vehicule_id) == $v->id)>
                            {{ $v->marque }} {{ $v->modele }} — {{ $v->immatriculation }} ({{ $v->nombre_places }} places)
                        </option>
                    @endforeach
                </select>
            @else
                <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">
                    Pas de véhicule enregistré.
                    <a href="{{ route('vehicules.create') }}" class="underline">Ajouter un véhicule</a>
                </p>
            @endif
        </div>

        <div class="mt-6 flex items-center gap-4">
            <x-primary-button>Enregistrer les modifications</x-primary-button>
            <a href="{{ route('trajets.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition text-sm">Annuler</a>
        </div>
    </form>
</div>
@endsection
