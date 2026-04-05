@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-6 sm:px-8 py-10">

    {{-- En-tête --}}
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Administration</span>
        </h1>
        <p class="mt-1 text-gray-600 dark:text-gray-300">Vue d'ensemble du système.</p>
    </div>

    @if(session('success'))
    <div class="mt-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 p-3 text-sm text-emerald-700 dark:text-emerald-300">
        {{ session('success') }}
    </div>
    @endif

    {{-- Statistiques --}}
    <div class="mt-8 grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
        <a href="{{ route('admin.users') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-indigo-600/10 text-indigo-600 flex items-center justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Utilisateurs</div>
                    <div class="mt-0.5 text-2xl font-bold text-indigo-600">{{ $stats['users'] ?? 0 }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.trajets') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-fuchsia-600/10 text-fuchsia-600 flex items-center justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Trajets</div>
                    <div class="mt-0.5 text-2xl font-bold text-fuchsia-600">{{ $stats['trajets'] ?? 0 }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.reservations') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-cyan-600/10 text-cyan-600 flex items-center justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h13M8 12h13M8 17h13M3 7h.01M3 12h.01M3 17h.01"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Réservations</div>
                    <div class="mt-0.5 text-2xl font-bold text-cyan-600">{{ $stats['reservations'] ?? 0 }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.vehicules') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-amber-600/10 text-amber-600 flex items-center justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Véhicules</div>
                    <div class="mt-0.5 text-2xl font-bold text-amber-600">{{ $stats['vehicules'] ?? 0 }}</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.evaluations') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition group">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-emerald-600/10 text-emerald-600 flex items-center justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927l1.902 3.856 4.257.618-3.08 3 .586 4.238-3.665-1.928-3.665 1.928 .586-4.238-3.08-3 4.257-.618z"/></svg>
                </div>
                <div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Évaluations</div>
                    <div class="mt-0.5 text-2xl font-bold text-emerald-600">{{ $stats['evaluations'] ?? 0 }}</div>
                </div>
            </div>
        </a>
    </div>

    {{-- Accès rapides --}}
    <div class="mt-10">
        <h3 class="text-lg font-bold mb-4">Accès rapides</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.users') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-indigo-600/10 text-indigo-600 flex items-center justify-center">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-sm">Gérer les utilisateurs</div>
                    <div class="text-xs text-gray-500">Rôles et statuts</div>
                </div>
            </a>
            <a href="{{ route('admin.trajets') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-fuchsia-600/10 text-fuchsia-600 flex items-center justify-center">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-sm">Gérer les trajets</div>
                    <div class="text-xs text-gray-500">Modérer et supprimer</div>
                </div>
            </a>
            <a href="{{ route('admin.reservations') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 p-5 hover:shadow-md transition flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-cyan-600/10 text-cyan-600 flex items-center justify-center">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-sm">Gérer les réservations</div>
                    <div class="text-xs text-gray-500">Voir et supprimer</div>
                </div>
            </a>
        </div>
    </div>

</div>
@endsection
