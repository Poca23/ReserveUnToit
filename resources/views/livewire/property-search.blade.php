<div>
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Rechercher une propriété</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Mot-clé</label>
                <input type="text" wire:model.live="search" id="search" 
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="Nom ou description...">
            </div>
            
            <div>
                <label for="minPrice" class="block text-sm font-medium text-gray-700 mb-1">Prix minimum</label>
                <input type="number" wire:model.live="minPrice" id="minPrice" 
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="€">
            </div>
            
            <div>
                <label for="maxPrice" class="block text-sm font-medium text-gray-700 mb-1">Prix maximum</label>
                <input type="number" wire:model.live="maxPrice" id="maxPrice" 
                    class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                    placeholder="€">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties as $property)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <div class="h-48 bg-gray-100">
                    <img src="{{ $property->image_url }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="text-xl font-bold mb-2">{{ $property->name }}</h3>
                    <!-- Modifié pour utiliser Str::limit sur le contenu sans les balises HTML -->
                    <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($property->description), 100) }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-bold">{{ number_format($property->price_per_night, 2) }} €/nuit</span>
                        <!-- Bouton bien visible avec couleur de fond explicite -->
                        <a href="{{ route('properties.show', $property) }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Voir détails
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <p>Aucune propriété trouvée correspondant à vos critères.</p>
            </div>
        @endforelse
    </div>
</div>
