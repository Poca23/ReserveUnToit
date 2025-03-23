<div class="bg-white shadow-md rounded-lg overflow-hidden transition-transform hover:scale-[1.02]">
    <div class="h-48 bg-gray-200">
        <!-- Image de la propriété -->
        <img src="{{ $property->image_url }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
    </div>
    <div class="p-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $property->name }}</h3>
        <!-- Modifié pour afficher correctement le texte sans les balises HTML -->
        <p class="text-gray-600 mb-4 line-clamp-2">{{ strip_tags($property->description) }}</p>
        <div class="flex justify-between items-center">
            <span class="text-blue-600 font-bold">{{ number_format($property->price_per_night, 2) }} € / nuit</span>
            <!-- Bouton bien visible avec couleur de fond -->
            <a href="{{ route('properties.show', $property) }}" 
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Voir détails
            </a>
        </div>
    </div>
</div>
