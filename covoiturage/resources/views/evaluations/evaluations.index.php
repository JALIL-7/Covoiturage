@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Évaluations — Trajet {{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}</h1>

    <div class="mt-6">
        @if($evaluations->count())
            <ul class="space-y-3">
                @foreach($evaluations as $ev)
                <li class="border p-3 rounded bg-white">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="font-semibold">Note : {{ $ev->note }}/5</div>
                            <div class="text-sm text-gray-600">Par {{ $ev->user->name ?? 'Utilisateur' }} le {{ optional($ev->date)->format('d/m/Y') }}</div>
                            @if($ev->commentaire)
                                <div class="mt-2">{{ $ev->commentaire }}</div>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        @else
            <p>Aucune évaluation pour ce trajet.</p>
        @endif
    </div>
</div>
@endsection
