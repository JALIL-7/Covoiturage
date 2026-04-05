@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-6 sm:px-8">
    <div class="mt-8 mb-6">
        <h1 class="text-2xl font-bold">Réserver un trajet</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 text-red-700 p-3">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5">
        @if(isset($trajet) && $trajet)
            <div class="mb-4">
                <div class="font-semibold">{{ $trajet->ville_depart }} → {{ $trajet->ville_arrivee }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Le {{ optional($trajet->date)->format('d/m/Y') }} — {{ $trajet->heure }} — Places: {{ $trajet->places_disponibles }}</div>
            </div>
            <form method="POST" action="{{ url('/reservations') }}">
                @csrf
                <input type="hidden" name="trajet_id" value="{{ $trajet->id }}">
                <x-primary-button>Confirmer la réservation</x-primary-button>
            </form>
        @else
            <form method="POST" action="{{ url('/reservations') }}">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Sélectionner un trajet</label>
                    <select name="trajet_id" class="mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 w-full" required>
                        @foreach($trajets as $t)
                            <option value="{{ $t->id }}">
                                {{ $t->ville_depart }} → {{ $t->ville_arrivee }} — {{ optional($t->date)->format('d/m/Y') }} — {{ $t->heure }} — Places: {{ $t->places_disponibles }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <x-primary-button>Confirmer la réservation</x-primary-button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
