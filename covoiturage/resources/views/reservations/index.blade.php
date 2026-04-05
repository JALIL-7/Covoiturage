@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Mes réservations</span>
        </h1>
    </div>

    {{-- Filtre par date --}}
    <form method="GET" action="{{ route('reservations.index') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-4 shadow-sm mb-6">
        <div class="flex items-end gap-4">
            <div class="flex-1">
                <x-input-label value="Filtrer par date de trajet" />
                <x-text-input name="date" type="date" value="{{ request('date') }}" class="mt-1 block w-full" />
            </div>
            <x-primary-button type="submit">Filtrer</x-primary-button>
            @if(request('date'))
            <a href="{{ route('reservations.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Réinitialiser</a>
            @endif
        </div>
    </form>

    @if(session('success'))
    <div class="mb-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-4 text-sm text-emerald-700 dark:text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    <div class="mt-2">
        @if($reservations->count())
            <ul class="space-y-4">
                @foreach($reservations as $res)
                <li class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm">
                    <div class="flex justify-between items-center gap-4">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-lg bg-indigo-600/10 text-indigo-700 dark:text-indigo-300 flex items-center justify-center shrink-0">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold">{{ $res->trajet->ville_depart }} → {{ $res->trajet->ville_arrivee }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Le {{ optional($res->trajet->date)->format('d/m/Y') }} à {{ $res->trajet->heure ?? '' }}
                                    &bull; {{ $res->trajet->prix ?? '—' }} FCFA
                                </div>
                                <div class="mt-2">
                                    @php
                                        $statut = strtolower($res->statut ?? '');
                                        $statClass = match(true) {
                                            str_contains($statut, 'confirm') => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                                            str_contains($statut, 'annul')   => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                            default => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statClass }}">{{ $res->statut }}</span>

                                    {{-- Lien pour évaluer si trajet passé --}}
                                    @if($res->trajet->date && $res->trajet->date->isPast())
                                    <a href="{{ url('/trajets/'.$res->trajet_id) }}" class="ml-2 text-xs text-amber-600 hover:underline">Évaluer ce trajet →</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(!$res->trajet->date || !$res->trajet->date->isPast())
                        <div class="shrink-0">
                            <form method="POST" action="{{ url('/reservations/'.$res->id) }}" onsubmit="return confirm('Annuler et supprimer cette réservation ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center rounded-xl px-4 py-2 text-sm bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 ring-1 ring-rose-200 dark:ring-rose-800 hover:bg-rose-100 dark:hover:bg-rose-900/40 transition">
                                    Annuler
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-10 text-center">
                <p class="text-gray-600 dark:text-gray-400">{{ request('date') ? 'Aucune réservation pour cette date.' : 'Vous n\'avez aucune réservation.' }}</p>
                <a href="{{ url('/trajets') }}" class="mt-3 inline-block text-indigo-600 hover:underline text-sm">Rechercher un trajet</a>
            </div>
        @endif
    </div>
</div>
@endsection
