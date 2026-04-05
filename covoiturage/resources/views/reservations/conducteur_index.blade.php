@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Réservations sur mes trajets</span>
        </h1>
    </div>

    @if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-4 text-sm text-emerald-700 dark:text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    <div class="mt-6">
        @if($reservations->count())
            <ul class="space-y-4">
                @foreach($reservations as $res)
                <li class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-lg bg-cyan-600/10 text-cyan-700 dark:text-cyan-300 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h13M8 12h13M8 17h13M3 7h.01M3 12h.01M3 17h.01"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">
                                    {{ $res->trajet->ville_depart }} → {{ $res->trajet->ville_arrivee }}
                                    @if($res->trajet->date) — {{ optional($res->trajet->date)->format('d/m/Y') }} @endif
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">
                                        Passager : {{ $res->passager->name ?? 'Utilisateur' }}
                                    </span>
                                    @if(isset($res->created_at))
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">
                                        Réservé le {{ $res->created_at->format('d/m/Y H:i') }}
                                    </span>
                                    @endif
                                    @php
                                        $statut = strtolower($res->statut ?? '');
                                        $statClass = match(true) {
                                            str_contains($statut, 'valid') || str_contains($statut, 'confirm') => 'bg-emerald-600 text-white',
                                            str_contains($statut, 'annul') => 'bg-rose-600 text-white',
                                            default => 'ring-1 ring-slate-300 dark:ring-gray-700'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs {{ $statClass }}">{{ $res->statut }}</span>
                                </div>
                            </div>
                        </div>
                        {{-- Pas de bouton Annuler côté conducteur --}}
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-10 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h13M8 12h13M8 17h13M3 7h.01M3 12h.01M3 17h.01"/>
                </svg>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Aucune réservation trouvée pour vos trajets.</p>
            </div>
        @endif
    </div>
</div>
@endsection
