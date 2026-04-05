@extends('layouts.app')
@section('content')
<section class="relative">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">

        {{-- En-tête --}}
        <div class="flex items-baseline justify-between">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Tableau de bord Conducteur</span>
                </h2>
                <p class="mt-1 text-gray-600 dark:text-gray-300">Bienvenue, <span class="font-semibold">{{ auth()->user()->name }}</span> — gérez vos trajets, véhicules et réservations.</p>
            </div>
        </div>

        @if(session('success'))
        <div class="mt-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-3 text-sm text-emerald-700 dark:text-emerald-300">
            {{ session('success') }}
        </div>
        @endif

        {{-- Cartes d'action --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- Trajets --}}
            <div class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="h-10 w-10 rounded-lg bg-indigo-600/10 text-indigo-700 dark:text-indigo-300 flex items-center justify-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">Mes trajets</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Publier ou parcourir les trajets.</p>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('trajets.create') }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition">Publier</a>
                                <a href="{{ url('/trajets') }}" class="inline-flex items-center rounded-xl px-4 py-2 ring-1 ring-slate-300 dark:ring-gray-700 text-sm">Voir tout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Véhicules --}}
            <div class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-start gap-3">
                    <div class="h-10 w-10 rounded-lg bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Véhicules</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Gérer vos véhicules.</p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('vehicules.create') }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-fuchsia-600 text-white text-sm hover:bg-fuchsia-700 transition">Ajouter</a>
                            <a href="{{ route('vehicules.index') }}" class="inline-flex items-center rounded-xl px-4 py-2 ring-1 ring-slate-300 dark:ring-gray-700 text-sm">Voir</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Réservations --}}
            <a href="{{ route('reservations.conducteur') }}" class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
                <div class="h-10 w-10 rounded-lg bg-cyan-600/10 text-cyan-700 dark:text-cyan-300 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h13M8 12h13M8 17h13M3 7h.01M3 12h.01M3 17h.01"/></svg>
                </div>
                <h3 class="mt-4 font-semibold">Réservations</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Passagers sur vos trajets.</p>
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-xl px-4 py-2 ring-1 ring-slate-300 dark:ring-gray-700 text-sm">Voir</span>
                </div>
            </a>

            {{-- Évaluations --}}
            <a href="{{ route('evaluations.conducteur') }}" class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
                <div class="h-10 w-10 rounded-lg bg-amber-600/10 text-amber-700 dark:text-amber-300 flex items-center justify-center">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927l1.902 3.856 4.257.618-3.08 3 .586 4.238-3.665-1.928-3.665 1.928 .586-4.238-3.08-3 4.257-.618z"/></svg>
                </div>
                <h3 class="mt-4 font-semibold">Évaluations</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Avis reçus sur vos trajets.</p>
                <div class="mt-4">
                    <span class="inline-flex items-center rounded-xl px-4 py-2 ring-1 ring-slate-300 dark:ring-gray-700 text-sm">Voir</span>
                </div>
            </a>
        </div>

        {{-- Section Mes Trajets publiés --}}
        <div class="mt-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold">Mes trajets publiés</h3>
                <a href="{{ route('trajets.create') }}" class="inline-flex items-center gap-1 rounded-xl px-4 py-2 bg-indigo-600 text-white text-sm hover:bg-indigo-700 transition">
                    + Nouveau trajet
                </a>
            </div>

            @php
                $mesTrajets = \App\Models\Trajet::where('conducteur_id', auth()->id())
                    ->withCount('reservations')
                    ->orderBy('date', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($mesTrajets->count())
                <div class="space-y-3">
                    @foreach($mesTrajets as $trajet)
                    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur px-5 py-4 shadow-sm flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="font-semibold">{{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $trajet->date->format('d/m/Y') }} à {{ $trajet->heure }}
                                &bull; {{ $trajet->prix }} FCFA
                                &bull; <span class="{{ $trajet->places_disponibles > 0 ? 'text-emerald-600' : 'text-rose-500' }}">{{ $trajet->places_disponibles }} place(s)</span>
                                &bull; {{ $trajet->reservations_count }} réservation(s)
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ url('/trajets/'.$trajet->id) }}" class="inline-flex items-center rounded-xl px-3 py-1.5 text-xs ring-1 ring-slate-300 dark:ring-gray-700 hover:bg-slate-50 dark:hover:bg-gray-800 transition">Voir</a>
                            <a href="{{ route('trajets.edit', $trajet) }}" class="inline-flex items-center rounded-xl px-3 py-1.5 text-xs bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 ring-1 ring-indigo-200 dark:ring-indigo-800 hover:bg-indigo-100 transition">Modifier</a>
                            <form action="{{ route('trajets.destroy', $trajet->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce trajet ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex items-center rounded-xl px-3 py-1.5 text-xs bg-rose-50 dark:bg-rose-900/20 text-rose-600 ring-1 ring-rose-200 dark:ring-rose-800 hover:bg-rose-100 transition">Supprimer</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3 text-right">
                    <a href="{{ url('/trajets') }}" class="text-sm text-indigo-600 hover:underline">Voir tous les trajets →</a>
                </div>
            @else
                <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore publié de trajet.</p>
                    <a href="{{ route('trajets.create') }}" class="mt-3 inline-block text-indigo-600 hover:underline text-sm">Publier votre premier trajet</a>
                </div>
            @endif
        </div>

    </div>
</section>
@endsection
