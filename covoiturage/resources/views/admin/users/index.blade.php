@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">
    <h2 class="text-2xl font-bold">Utilisateurs</h2>
    <div class="mt-6 overflow-x-auto rounded-xl ring-1 ring-black/5 bg-white/80 dark:bg-gray-900/80">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600 dark:text-gray-300 border-b border-slate-200/60 dark:border-gray-800">
                    <th class="p-3">Nom</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Rôle</th>
                    <th class="p-3">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr class="border-b border-slate-200/60 dark:border-gray-800">
                    <td class="p-3">{{ $u->name }} {{ $u->prenom ?? '' }}</td>
                    <td class="p-3">{{ $u->email }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.users.role', $u) }}" class="flex items-center gap-2">
                            @csrf
                            <select name="role" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800">
                                @foreach(['passager'=>'Passager','conducteur'=>'Conducteur','admin'=>'Admin'] as $val => $label)
                                    <option value="{{ $val }}" @selected($u->role === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button class="px-3 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition">Mettre à jour</button>
                        </form>
                    </td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('admin.users.status', $u) }}" class="flex items-center gap-2">
                            @csrf
                            <select name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800">
                                @foreach(['active'=>'Actif','suspendu'=>'Suspendu'] as $val => $label)
                                    <option value="{{ $val }}" @selected(($u->status ?? 'active') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button class="px-3 py-1 rounded-md bg-amber-600 text-white hover:bg-amber-700 transition">Appliquer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
