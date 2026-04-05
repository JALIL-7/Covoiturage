@extends('layouts.app')

@section('content')
<section x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" class="relative">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="pointer-events-none absolute -top-32 left-1/2 -translate-x-1/2 h-[600px] w-[1200px] bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-cyan-400 opacity-20 blur-3xl dark:opacity-25"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 py-16 sm:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div x-show="show" x-transition>
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Covoiturage moderne</span>
                    pour vos trajets quotidiens
                </h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    Trouvez ou proposez un trajet en quelques clics. Rapide, sûr et économique.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ url('/trajets') }}"
                       class="inline-flex items-center gap-2 rounded-xl px-6 py-3 bg-indigo-600 text-white shadow-sm hover:bg-indigo-700 active:bg-indigo-800 transition">
                        Rechercher un trajet
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    @guest
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center rounded-xl px-5 py-3 ring-1 ring-inset ring-slate-300 bg-white text-gray-900 hover:bg-slate-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-700 dark:hover:bg-gray-700 transition">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center rounded-xl px-5 py-3 bg-cyan-500 text-white hover:bg-cyan-600 active:bg-cyan-700 transition">
                        Inscription
                    </a>
                    @endguest
                </div>
                <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 backdrop-blur p-4 ring-1 ring-black/5">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-indigo-600/10 text-indigo-700 dark:text-indigo-300 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium">Sécurisé</div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 backdrop-blur p-4 ring-1 ring-black/5">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-fuchsia-600/10 text-fuchsia-700 dark:text-fuchsia-300 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium">Rapide</div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 backdrop-blur p-4 ring-1 ring-black/5">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-cyan-600/10 text-cyan-700 dark:text-cyan-300 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3 0 2.25 3 5 3 5s3-2.75 3-5c0-1.657-1.343-3-3-3z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium">Écologique</div>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 backdrop-blur p-4 ring-1 ring-black/5">
                        <div class="flex items-center gap-3">
                            <div class="h-9 w-9 rounded-lg bg-amber-600/10 text-amber-700 dark:text-amber-300 flex items-center justify-center">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h6m6 0h6M12 3v18"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium">Flexible</div>
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="show" x-transition class="relative">
                <div class="rounded-3xl ring-1 ring-black/5 bg-white dark:bg-gray-950 p-6">
                    <h3 class="text-xl font-semibold">À la une</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Trajets disponibles prochainement</p>
                    <div class="mt-4 space-y-3">
                        @forelse(($featuredTrajets ?? collect()) as $t)
                            <div class="rounded-xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <div class="font-medium">{{ $t->ville_depart }} → {{ $t->ville_arrivee }}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">Le {{ optional($t->date)->format('d/m/Y') }} à {{ $t->heure }}</div>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs bg-indigo-600 text-white">Prix {{ $t->prix }}</span>
                                            @php
                                                $places = (int) ($t->places_disponibles ?? 0);
                                                $placesClass = $places > 2 ? 'bg-emerald-600 text-white' : ($places > 0 ? 'bg-amber-500 text-white' : 'bg-rose-600 text-white');
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs {{ $placesClass }}">Places {{ $places }}</span>
                                            @if(!is_null($t->evaluations_avg_note))
                                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs ring-1 ring-slate-300 dark:ring-gray-700">⭐ {{ number_format($t->evaluations_avg_note, 1) }}/5</span>
                                            @endif
                                        </div>
                                    </div>
                                    <a href="{{ route('trajets.show', $t->id) }}" class="inline-flex items-center rounded-xl px-3 py-2 bg-indigo-600 text-white hover:bg-indigo-700 transition text-sm">Voir</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-600 dark:text-gray-400">Aucun trajet mis en avant pour le moment.</div>
                        @endforelse
                    </div>

                    @auth
                        @if(($vehicules ?? collect())->count())
                            <div class="mt-8">
                                <h3 class="text-xl font-semibold">Mes véhicules</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Accès rapide à vos fiches</p>
                                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($vehicules as $v)
                                        <div class="rounded-xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-4">
                                            <div class="flex items-start justify-between gap-3">
                                                <div>
                                                    <div class="font-medium">{{ $v->marque }} {{ $v->modele }}</div>
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ $v->immatriculation }} — {{ $v->nombre_places }} places</div>
                                                </div>
                                                <a href="{{ route('vehicules.show', $v->id) }}" class="inline-flex items-center rounded-xl px-3 py-2 ring-1 ring-slate-300 dark:ring-gray-700 text-sm">Voir</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
