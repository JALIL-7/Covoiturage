@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Espace Passager</span>
        </h1>
        <p class="mt-1 text-gray-600 dark:text-gray-300">Bienvenue, <span class="font-semibold">{{ auth()->user()->name }}</span> — recherchez un trajet ou consultez vos réservations.</p>
    </div>

    @if(session('success'))
    <div class="mt-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-3 text-sm text-emerald-700 dark:text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- Cartes d'action --}}
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="{{ url('/trajets') }}" class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-indigo-600/10 text-indigo-700 dark:text-indigo-300 flex items-center justify-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Rechercher un trajet</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Trouvez rapidement un covoiturage.</p>
                </div>
            </div>
        </a>

        <a href="{{ url('/reservations') }}" class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-cyan-600/10 text-cyan-700 dark:text-cyan-300 flex items-center justify-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h13M8 12h13M8 17h13M3 7h.01M3 12h.01M3 17h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Mes réservations</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Consultez et gérez vos réservations.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}" class="group rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-xl bg-amber-600/10 text-amber-700 dark:text-amber-300 flex items-center justify-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Mon profil</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Informations et sécurité du compte.</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Dernières réservations --}}
    <div class="mt-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold">Mes dernières réservations</h3>
            <a href="{{ url('/reservations') }}" class="text-sm text-indigo-600 hover:underline">Voir tout →</a>
        </div>

        @php
            $mesResa = \App\Models\Reservation::where('passager_id', auth()->id())
                ->with('trajet')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
        @endphp

        @if($mesResa->count())
        <div class="space-y-3">
            @foreach($mesResa as $res)
            <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur px-5 py-4 shadow-sm flex flex-wrap items-center justify-between gap-3">
                <div>
                    <div class="font-semibold">{{ $res->trajet->ville_depart ?? '?' }} → {{ $res->trajet->ville_arrivee ?? '?' }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        Le {{ optional($res->trajet->date)->format('d/m/Y') }} — Prix : {{ $res->trajet->prix ?? '—' }} FCFA
                    </div>
                </div>
                @php
                    $statut = strtolower($res->statut ?? '');
                    $sc = str_contains($statut, 'confirm') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300';
                @endphp
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $sc }}">{{ $res->statut }}</span>
            </div>
            @endforeach
        </div>
        @else
            <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-8 text-center">
                <p class="text-gray-500 dark:text-gray-400">Vous n'avez aucune réservation pour le moment.</p>
                <a href="{{ url('/trajets') }}" class="mt-2 inline-block text-indigo-600 hover:underline text-sm">Trouver un trajet</a>
            </div>
        @endif
    </div>
</div>
@endsection
