@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">
    <h2 class="text-2xl font-bold">Véhicules</h2>
    <div class="mt-6 overflow-x-auto rounded-xl ring-1 ring-black/5 bg-white/80 dark:bg-gray-900/80">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600 dark:text-gray-300 border-b border-slate-200/60 dark:border-gray-800">
                    <th class="p-3">Propriétaire</th>
                    <th class="p-3">Marque</th>
                    <th class="p-3">Modèle</th>
                    <th class="p-3">Immatriculation</th>
                    <th class="p-3">Places</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicules as $v)
                <tr class="border-b border-slate-200/60 dark:border-gray-800">
                    <td class="p-3">{{ $v->user->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ $v->marque }}</td>
                    <td class="p-3">{{ $v->modele }}</td>
                    <td class="p-3">{{ $v->immatriculation }}</td>
                    <td class="p-3">{{ $v->nombre_places }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.vehicules.destroy', $v) }}" onsubmit="return confirm('Supprimer ce véhicule ?');">
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
