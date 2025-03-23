<x-app-layout>
    <!-- Hero Section -->
    <section class="relative h-[500px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1920&q=80')">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative container mx-auto px-4 h-full flex flex-col justify-center items-center text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Trouvez votre prochain toit temporaire</h1>
            <p class="text-xl mb-8">Des locations de qualité pour vos vacances et déplacements professionnels</p>
            
            <!-- Barre de recherche rapide -->
            <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-3xl text-gray-800">
                <form class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-600">Destination</label>
                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Où allez-vous ?">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-600">Dates</label>
                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Arrivée - Départ">
                    </div>
                    <div class="md:flex-none md:self-end">
                        <button type="submit" class="w-full md:w-auto bg-primary hover:bg-primary-dark text-white font-bold py-2 px-6 rounded-md transition">
                            Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Comment ça marche -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Comment ça marche</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Recherchez</h3>
                    <p class="text-gray-600">Trouvez la propriété idéale parmi notre sélection</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Réservez</h3>
                    <p class="text-gray-600">Choisissez vos dates et effectuez votre paiement en ligne</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Profitez</h3>
                    <p class="text-gray-600">Recevez votre confirmation et les détails d'accès</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Propriétés en vedette -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold">Propriétés en vedette</h2>
                <a href="{{ route('properties.index') }}" class="text-primary hover:text-primary-dark font-medium">
                    Voir toutes nos propriétés →
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProperties as $property)
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">
                    <img src="{{ $property->image_url ?? $propertyPlaceholder }}" alt="{{ $property->name }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2">{{ $property->name }}</h3>
                        <p class="text-primary font-bold">{{ number_format($property->price_per_night, 2) }} € / nuit</p>
                        <a href="{{ route('properties.show', $property) }}" class="mt-3 inline-block text-sm text-primary hover:underline">
                            Voir les détails →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Destinations populaires -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-10">Destinations populaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($popularDestinations as $destination)
                <a href="{{ route('properties.index', ['destination' => $destination['name']]) }}" class="block group">
                    <div class="relative rounded-lg overflow-hidden h-64 shadow-md">
                        <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black to-transparent opacity-70"></div>
                        <div class="absolute bottom-0 left-0 p-4 text-white">
                            <h3 class="text-xl font-bold">{{ $destination['name'] }}</h3>
                            <p>{{ $destination['count'] }} propriétés</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Témoignages -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Ce que disent nos clients</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full mr-4">
                        <div>
                            <p class="font-bold">{{ $testimonial['name'] }}</p>
                            <p class="text-sm text-gray-500">{{ $testimonial['date'] }}</p>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 italic">"{{ $testimonial['comment'] }}"</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Avantages -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Pourquoi choisir RéserveUnToit</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Réservation flexible</h3>
                    <p class="text-gray-600">Modifiez ou annulez jusqu'à 48h avant l'arrivée</p>
                </div>
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Paiement sécurisé</h3>
                    <p class="text-gray-600">Transactions protégées et transparentes</p>
                </div>
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Support 24/7</h3>
                    <p class="text-gray-600">Une équipe à votre écoute à tout moment</p>
                </div>
                <div class="text-center">
                    <div class="bg-secondary text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Propriétés vérifiées</h3>
                    <p class="text-gray-600">Toutes nos annonces sont contrôlées</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-primary">
        <div class="container mx-auto px-4 text-center text-white">
            <h2 class="text-3xl font-bold mb-6">Prêt à découvrir votre prochain lieu de séjour ?</h2>
            <a href="{{ route('properties.index') }}" class="inline-block bg-white text-primary font-bold py-3 px-8 rounded-md hover:bg-gray-100 transition">
                Explorer nos propriétés
            </a>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16">
        <div class="container mx-auto px-4 max-w-xl text-center">
            <h2 class="text-3xl font-bold mb-4">Restez informé</h2>
            <p class="text-gray-600 mb-6">Recevez en avant-première nos meilleures offres et nouveautés</p>
            <form class="flex flex-col sm:flex-row gap-3">
                <input type="email" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" placeholder="Votre adresse email">
                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-6 rounded-md transition">
                    S'inscrire
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
