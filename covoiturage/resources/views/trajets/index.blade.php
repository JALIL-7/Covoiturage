@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Rechercher un trajet</span>
        </h1>
    </div>
    @include('trajets._search')

    <div class="mt-6">
        @if($trajets->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($trajets as $trajet)
                <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="font-semibold text-lg">{{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Le {{ $trajet->date->format('d/m/Y') }} à {{ $trajet->heure }}</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-indigo-600 text-white">Prix {{ $trajet->prix }}</span>
                                @php
                                    $places = (int) $trajet->places_disponibles;
                                    $placesClass = $places > 2 ? 'bg-emerald-600 text-white' : ($places > 0 ? 'bg-amber-500 text-white' : 'bg-rose-600 text-white');
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs {{ $placesClass }}">Places {{ $places }}</span>
                                @if(!is_null($trajet->evaluations_avg_note))
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">
                                        ⭐ {{ number_format($trajet->evaluations_avg_note, 1) }}/5
                                    </span>
                                @endif
                                @if(isset($trajet->reservations_count))
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">{{ $trajet->reservations_count }} réservations</span>
                                @endif
                            </div>
                        </div>
                        <svg class="hidden sm:block h-12 w-20 text-indigo-300/60 dark:text-indigo-600/40" viewBox="0 0 200 120" fill="none" stroke="currentColor" stroke-width="6">
                            <path d="M10,100 C60,70 90,90 110,70 C130,50 150,50 190,30" stroke-linecap="round"/>
                            <circle cx="65" cy="98" r="8" fill="currentColor"/>
                            <circle cx="120" cy="88" r="8" fill="currentColor"/>
                        </svg>
                    </div>
                    <div class="mt-4">
                        <a href="{{ url('/trajets/'.$trajet->id) }}" class="inline-flex items-center rounded-xl px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 transition">Voir le trajet</a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $trajets->links() }}</div>
        @else
            <p class="text-gray-600 dark:text-gray-400">Aucun trajet trouvé correspondant à votre recherche.</p>
        @endif
    </div>
</div>
@endsection
