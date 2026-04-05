@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight"><span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Détails du véhicule</span></h1>
    </div>
    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-6 shadow-sm">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h2 class="text-xl font-semibold">{{ $vehicule->marque }} {{ $vehicule->modele }}</h2>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">{{ $vehicule->immatriculation }}</span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-cyan-500 text-white">{{ $vehicule->nombre_places }} places</span>
                </div>
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">Propriétaire : {{ $vehicule->user->name ?? '—' }}</p>
            </div>
            <svg class="hidden sm:block h-16 w-24 text-fuchsia-300/60 dark:text-fuchsia-600/40" viewBox="0 0 200 120" fill="none" stroke="currentColor" stroke-width="6">
                <rect x="30" y="60" width="90" height="25" rx="8" />
                <circle cx="55" cy="92" r="9" fill="currentColor"/>
                <circle cx="105" cy="92" r="9" fill="currentColor"/>
            </svg>
        </div>
    </div>
   
     <div class="mt-4">
            <a href="{{ route('vehicules.index') }}" class="text-indigo-600 hover:underline">Retour à mes véhicules</a>
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('vehicules.edit', $vehicule->id) }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 transition">Modifier</a>
            <form action="{{ route('vehicules.destroy', $vehicule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">
                @csrf
                @method('DELETE')
                <x-danger-button class="ml-2">Supprimer</x-danger-button>
            </form>
        </div>
    
</div>
@endsection
