@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 sm:px-8">
    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-6 shadow-sm mt-6">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h1 class="text-2xl font-bold">{{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}</h1>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">Le {{ $trajet->date->format('d/m/Y') }}</span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">{{ $trajet->heure }}</span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-indigo-600 text-white">Prix {{ $trajet->prix }} FCFA</span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-cyan-500 text-white">{{ $trajet->places_disponibles }} place(s)</span>
                </div>
            </div>
            <svg class="hidden sm:block h-20 w-32 text-indigo-300/60 dark:text-indigo-600/40" viewBox="0 0 200 120" fill="none" stroke="currentColor" stroke-width="6">
                <path d="M10,100 C60,70 90,90 110,70 C130,50 150,50 190,30" stroke-linecap="round"/>
                <circle cx="65" cy="98" r="8" fill="currentColor"/>
                <circle cx="120" cy="88" r="8" fill="currentColor"/>
            </svg>
        </div>

        {{-- Conducteur --}}
        @if($trajet->conducteur)
        <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Conducteur</h3>
            <p class="font-medium">{{ $trajet->conducteur->name ?? '—' }}</p>
        </div>
        @endif

        {{-- Véhicule --}}
        @if($trajet->vehicule)
        <div class="mt-4 border-t border-gray-100 dark:border-gray-800 pt-4">
            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Véhicule</h3>
            <div class="rounded-xl bg-fuchsia-50 dark:bg-fuchsia-900/20 ring-1 ring-fuchsia-200 dark:ring-fuchsia-800 px-4 py-3 inline-flex items-center gap-3">
                <svg class="h-7 w-7 text-fuchsia-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                </svg>
                <div>
                    <div class="font-semibold text-fuchsia-700 dark:text-fuchsia-300">{{ $trajet->vehicule->marque }} {{ $trajet->vehicule->modele }}</div>
                    <div class="text-xs text-gray-500 mt-0.5">Immat. {{ $trajet->vehicule->immatriculation }} &bull; {{ $trajet->vehicule->nombre_places }} places</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Actions : seulement si c'est le conducteur propriétaire du trajet --}}
        @auth
        @if(auth()->user()->id === $trajet->conducteur_id)
        <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4 flex flex-wrap gap-3 justify-end">
            <a href="{{ route('trajets.edit', $trajet) }}" class="inline-flex items-center rounded-xl px-4 py-2 ring-1 ring-slate-300 dark:ring-gray-700 hover:bg-slate-50 dark:hover:bg-gray-800 transition text-sm">Modifier</a>
            <form action="{{ route('trajets.destroy', $trajet->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');">
                @csrf
                @method('DELETE')
                <x-danger-button>Supprimer</x-danger-button>
            </form>
            {{-- Réservations de CE trajet uniquement --}}
            <a href="{{ route('reservations.conducteur.trajet', $trajet) }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-cyan-600 text-white text-sm hover:bg-cyan-700 transition">Voir les réservations</a>
        </div>
        @endif
        @endauth

        {{-- Section Passager --}}
        @auth
        @if(auth()->user()->role === 'passager')
            @php
                $trajetPasse = $trajet->date->isPast();
                $dejaReserve = $trajet->reservations->where('passager_id', auth()->id())->count() > 0;
                $dejaEvalue = $trajet->evaluations->where('user_id', auth()->id())->count() > 0;
            @endphp

            @if(!$trajetPasse && !$dejaReserve && $trajet->places_disponibles > 0)
            {{-- Trajet futur : permettre la réservation --}}
            <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-4">
                <h3 class="font-semibold mb-3">Réserver ce trajet</h3>
                <form method="POST" action="{{ route('reservations.store_passager') }}">
                    @csrf
                    <input type="hidden" name="trajet_id" value="{{ $trajet->id }}" />
                    <x-primary-button>Réserver ma place</x-primary-button>
                </form>
            </div>
            @elseif(!$trajetPasse && $dejaReserve)
            {{-- Déjà réservé, trajet pas encore passé --}}
            <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                    Vous avez une réservation sur ce trajet
                </span>
            </div>
            @elseif($trajetPasse && $dejaReserve && !$dejaEvalue)
            {{-- Trajet passé + réservé → peut évaluer --}}
            <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl p-4">
                <h3 class="font-semibold mb-1">Évaluer ce trajet</h3>
                <p class="text-sm text-gray-500 mb-3">Le trajet est terminé. Partagez votre expérience !</p>
                <form method="POST" action="{{ url('/evaluations') }}">
                    @csrf
                    <input type="hidden" name="trajet_id" value="{{ $trajet->id }}" />
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label value="Note (1 à 5)" />
                            <x-text-input type="number" name="note" min="1" max="5" value="{{ old('note') }}" class="mt-1 w-24" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label value="Commentaire" />
                            <x-text-input name="commentaire" value="{{ old('commentaire') }}" class="mt-1 w-full" placeholder="Votre avis sur ce trajet..." />
                        </div>
                    </div>
                    <div class="mt-4">
                        <x-primary-button>Envoyer mon évaluation</x-primary-button>
                    </div>
                </form>
            </div>
            @elseif($trajetPasse && $dejaReserve && $dejaEvalue)
            <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm bg-amber-100 text-amber-700 dark:bg-amber-900/30">Vous avez déjà évalué ce trajet</span>
            </div>
            @elseif($trajet->places_disponibles <= 0 && !$dejaReserve)
            <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm bg-rose-100 text-rose-700">Complet — plus de places disponibles</span>
            </div>
            @endif
        @endif
        @else
        <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4">
            <x-primary-button onclick="window.location='{{ route('login') }}'">Connectez-vous pour réserver</x-primary-button>
        </div>
        @endauth

        {{-- Évaluations déjà publiées --}}
        @if($trajet->evaluations->count())
        <div class="mt-5 border-t border-gray-100 dark:border-gray-800 pt-4">
            <h3 class="font-semibold mb-3 text-sm text-gray-500 uppercase tracking-wide">Avis des passagers ({{ $trajet->evaluations->count() }})</h3>
            <div class="space-y-3">
                @foreach($trajet->evaluations as $ev)
                <div class="rounded-xl bg-gray-50 dark:bg-gray-800/50 p-3 flex items-start gap-3">
                    <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(substr($ev->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-sm">{{ $ev->user->name ?? 'Anonyme' }}</span>
                            <span class="text-xs text-amber-500">{{ str_repeat('★', $ev->note) }}{{ str_repeat('☆', 5 - $ev->note) }}</span>
                        </div>
                        @if($ev->commentaire)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">{{ $ev->commentaire }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-5 text-right">
            <a href="{{ url('/trajets') }}" class="text-indigo-600 hover:underline text-sm">← Retour aux résultats</a>
        </div>
    </div>
</div>
@endsection
