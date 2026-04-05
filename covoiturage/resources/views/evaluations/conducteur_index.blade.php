@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Évaluations sur mes trajets</span>
        </h1>
    </div>

    {{-- Filtre par date --}}
    <form method="GET" action="{{ route('evaluations.conducteur') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-4 shadow-sm mb-6">
        <div class="flex items-end gap-4">
            <div class="flex-1">
                <x-input-label value="Filtrer par date de trajet" />
                <x-text-input name="date" type="date" value="{{ $filterDate }}" class="mt-1 block w-full" />
            </div>
            <x-primary-button type="submit">Filtrer</x-primary-button>
            @if($filterDate)
            <a href="{{ route('evaluations.conducteur') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Réinitialiser</a>
            @endif
        </div>
    </form>

    <div class="mt-2">
        @if($evaluations->count())
            <ul class="space-y-4">
                @foreach($evaluations as $ev)
                <li class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 flex items-center justify-center text-sm font-bold shrink-0">
                                {{ $ev->note }}
                            </div>
                            <div>
                                <div class="font-semibold">{{ $ev->trajet->ville_depart }} → {{ $ev->trajet->ville_arrivee }}
                                    @if($ev->trajet->date) <span class="text-sm font-normal text-gray-500">— {{ optional($ev->trajet->date)->format('d/m/Y') }}</span> @endif
                                </div>
                                <div class="text-sm text-amber-500 mt-0.5">
                                    {{ str_repeat('★', $ev->note) }}{{ str_repeat('☆', 5 - $ev->note) }}
                                    <span class="text-gray-500 ml-1">par {{ $ev->user->name ?? 'Utilisateur' }}</span>
                                </div>
                                @if($ev->commentaire)
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 italic">"{{ $ev->commentaire }}"</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 shrink-0">{{ optional($ev->date)->format('d/m/Y') }}</div>
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-10 text-center">
                <p class="text-gray-500 dark:text-gray-400">Aucune évaluation trouvée{{ $filterDate ? ' pour cette date' : '' }}.</p>
            </div>
        @endif
    </div>
</div>
@endsection
