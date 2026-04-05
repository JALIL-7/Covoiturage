@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">
    <h2 class="text-2xl font-bold">Trajets</h2>
    <div class="mt-6 overflow-x-auto rounded-xl ring-1 ring-black/5 bg-white/80 dark:bg-gray-900/80">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600 dark:text-gray-300 border-b border-slate-200/60 dark:border-gray-800">
                    <th class="p-3">Par</th>
                    <th class="p-3">Départ</th>
                    <th class="p-3">Arrivée</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Prix</th>
                    <th class="p-3">Places</th>
                    <th class="p-3">Réservations</th>
                    <th class="p-3">Note moy.</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($trajets as $t)
                <tr class="border-b border-slate-200/60 dark:border-gray-800">
                    <td class="p-3">{{ optional($t->conducteur)->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ $t->ville_depart }}</td>
                    <td class="p-3">{{ $t->ville_arrivee }}</td>
                    <td class="p-3">{{ \Illuminate\Support\Str::of(optional($t->date)->format('d/m/Y')) }}</td>
                    <td class="p-3">{{ $t->prix }}</td>
                    <td class="p-3">{{ $t->places_disponibles }}</td>
                    <td class="p-3">{{ $t->reservations_count }}</td>
                    <td class="p-3">{{ number_format((float)($t->evaluations_avg_note ?? 0), 1) }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.trajets.destroy', $t) }}" onsubmit="return confirm('Supprimer ce trajet ?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700 transition">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
