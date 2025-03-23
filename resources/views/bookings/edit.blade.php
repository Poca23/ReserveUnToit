<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier la réservation') }}
            </h2>
            <a href="{{ route('bookings.show', $booking) }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Formulaire de modification -->
                        <div class="lg:col-span-2">
                            <h3 class="text-xl font-semibold mb-6">{{ $booking->property->name }}</h3>
                            
                            <form action="{{ route('bookings.update', $booking) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                @if($errors->any())
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                        <ul class="list-disc pl-4">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <div class="mb-6">
                                    <x-input-label for="start_date" :value="__('Date d\'arrivée')" />
                                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date', $booking->start_date->format('Y-m-d'))" required />
                                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                                </div>
                                
                                <div class="mb-6">
                                    <x-input-label for="end_date" :value="__('Date de départ')" />
                                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date', $booking->end_date->format('Y-m-d'))" required />
                                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                                </div>
                                
                                <div class="flex items-center justify-end mt-8">
                                    <x-primary-button>
                                        {{ __('Enregistrer les modifications') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Informations sur la propriété -->
                        <div class="bg-gray-50 p-6 rounded-lg self-start">
                            <h4 class="text-lg font-medium mb-4">Informations sur la propriété</h4>
                            <p class="mb-4 text-sm">{{ $booking->property->description }}</p>
                            
                            <div class="border-t pt-4 mt-4">
                                <h5 class="text-md font-medium mb-3">Tarifs</h5>
                                <div class="flex justify-between text-sm">
                                    <span>Prix par nuit</span>
                                    <span class="font-medium">{{ number_format($booking->property->price_per_night, 2) }} €</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 text-xs text-gray-600">
                                <p>Note: La modification des dates est soumise à disponibilité et doit être effectuée au moins 48h avant le début du séjour.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
