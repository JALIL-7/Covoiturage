<form method="GET" action="{{ url('/trajets') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-5 shadow-sm">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <x-input-label value="Ville départ" />
            <x-text-input name="ville_depart" type="text" value="{{ old('ville_depart', $filters['ville_depart'] ?? '') }}" class="mt-1 block w-full" placeholder="ex: Dakar" />
        </div>
        <div>
            <x-input-label value="Ville arrivée" />
            <x-text-input name="ville_arrivee" type="text" value="{{ old('ville_arrivee', $filters['ville_arrivee'] ?? '') }}" class="mt-1 block w-full" placeholder="ex: Thiès" />
        </div>
        <div>
            <x-input-label value="Date" />
            <x-text-input name="date" type="date" value="{{ old('date', $filters['date'] ?? '') }}" class="mt-1 block w-full" />
        </div>
    </div>

    <div class="flex items-center gap-3 mt-4">
        <x-primary-button type="submit">Rechercher</x-primary-button>
        <a href="{{ url('/trajets') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">Réinitialiser</a>
    </div>
</form>
