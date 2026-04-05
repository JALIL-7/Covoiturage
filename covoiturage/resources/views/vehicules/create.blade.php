 @extends('layouts.app')
 @section('content')
 <div class="max-w-2xl mx-auto px-6 sm:px-8">
     <div class="mt-8 mb-6 text-center">
         <h1 class="text-3xl font-bold tracking-tight"><span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-fuchsia-600 to-cyan-500">Ajouter un véhicule</span></h1>
     </div>

     <form method="POST" action="{{ route('vehicules.store') }}" class="rounded-2xl bg-white/70 dark:bg-gray-900/70 ring-1 ring-black/5 backdrop-blur p-6 shadow-sm">
     @csrf
         <div>
             <x-input-label value="Marque" />
             <x-text-input type="text" name="marque" value="{{ old('marque') }}" class="mt-1 w-full" required />
         </div>
         <div class="mt-3">
             <x-input-label value="Modèle" />
             <x-text-input type="text" name="modele" value="{{ old('modele') }}" class="mt-1 w-full" required />
            </div>
            <div class="mt-3">
                <x-input-label value="Immatriculation" />
                <x-text-input type="text" name="immatriculation" value="{{ old('immatriculation') }}" class="mt-1 w-full" required />
            </div>
            <div class="mt-3">
                <x-input-label value="Nombre de places" />
                <x-text-input type="number" name="nombre_places" value="{{ old('nombre_places') }}" class="mt-1 w-full" required />
            </div>  
            <div class="mt-4">
                <x-primary-button type="submit">Enregistrer</x-primary-button>
                <a href="{{ url('/vehicules') }}" class="ml-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition">Annuler</a>
            </div>
     </form>
    </div>
    @endsection

