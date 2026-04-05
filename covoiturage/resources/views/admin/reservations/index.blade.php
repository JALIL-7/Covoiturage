@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">
    <h2 class="text-2xl font-bold">Réservations</h2>
    <div class="mt-6 overflow-x-auto rounded-xl ring-1 ring-black/5 bg-white/80 dark:bg-gray-900/80">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600 dark:text-gray-300 border-b border-slate-200/60 dark:border-gray-800">
                    <th class="p-3">Passager</th>
                    <th class="p-3">Trajet</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $r)
                <tr class="border-b border-slate-200/60 dark:border-gray-800">
                    <td class="p-3">{{ $r->passager->name ?? 'N/A' }}</td>
                    <td class="p-3">
                        {{ $r->trajet->ville_depart ?? '' }} → {{ $r->trajet->ville_arrivee ?? '' }}
                    </td>
                    <td class="p-3">{{ optional($r->date_reservation)->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ $r->statut }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.reservations.destroy', $r) }}" onsubmit="return confirm('Supprimer cette réservation ?');">
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
