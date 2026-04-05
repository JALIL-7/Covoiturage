@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Mes véhicules</span>
        </h1>
    </div>
  
    <div class="mt-6">
        @if($vehicules->count())
            <ul class="space-y-4">
                @foreach($vehicules as $vehicule)
                <li class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $vehicule->marque }} {{ $vehicule->modele }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $vehicule->immatriculation }} — {{ $vehicule->nombre_places }} places</div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('vehicules.show', $vehicule->id) }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 transition">Voir les détails</a>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="mb-4 text-right">
                <a href="{{ url('/vehicules/create') }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 transition">Ajouter un véhicule</a>
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400">Vous n'avez pas encore de véhicule enregistré.</p>
        @endif
    </div>
</div>
@endsection
