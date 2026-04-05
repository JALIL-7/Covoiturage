@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('reservations.conducteur') }}" class="text-sm text-indigo-600 hover:underline">← Toutes mes réservations</a>
        </div>
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">
                Réservations — {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}
            </span>
        </h1>
        <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm">
            Le {{ $trajet->date->format('d/m/Y') }} à {{ $trajet->heure }} &bull; {{ $trajet->places_disponibles }} place(s) restante(s)
        </p>
    </div>

    @if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-4 text-sm text-emerald-700 dark:text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    <div class="mt-4">
        @if($reservations->count())
            <ul class="space-y-4">
                @foreach($reservations as $res)
                <li class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 flex items-center justify-center text-sm font-bold shrink-0">
                                {{ strtoupper(substr($res->passager->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold">{{ $res->passager->name ?? 'Passager inconnu' }}</div>
                                <div class="text-sm text-gray-500 mt-0.5">Réservé le {{ $res->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>
                        @php
                            $statut = strtolower($res->statut ?? '');
                            $sc = str_contains($statut, 'confirm') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300';
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $sc }}">{{ $res->statut }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-10 text-center">
                <p class="text-gray-500">Aucune réservation pour ce trajet.</p>
            </div>
        @endif
    </div>
</div>
@endsection
