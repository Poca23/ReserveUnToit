<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Paiement de la réservation') }}
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
                        <!-- Formulaire de paiement -->
                        <div class="lg:col-span-2">
                            <h3 class="text-xl font-semibold mb-6">Informations de paiement</h3>
                            
                            <form action="{{ route('bookings.process-payment', $booking) }}" method="POST">
                                @csrf
                                
                                <div class="mb-6">
                                    <x-input-label for="card_number" :value="__('Numéro de carte')" />
                                    <x-text-input id="card_number" name="card_number" type="text" class="mt-1 block w-full" placeholder="1234 5678 9012 3456" required />
                                    <x-input-error :messages="$errors->get('card_number')" class="mt-2" />
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <x-input-label for="expiry_date" :value="__('Date d\'expiration (MM/YY)')" />
                                        <x-text-input id="expiry_date" name="expiry_date" type="text" class="mt-1 block w-full" placeholder="MM/YY" required />
                                        <x-input-error :messages="$errors->get('expiry_date')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="cvv" :value="__('Code de sécurité (CVV)')" />
                                        <x-text-input id="cvv" name="cvv" type="text" class="mt-1 block w-full" placeholder="123" required />
                                        <x-input-error :messages="$errors->get('cvv')" class="mt-2" />
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <x-input-label for="name_on_card" :value="__('Nom sur la carte')" />
                                    <x-text-input id="name_on_card" name="name_on_card" type="text" class="mt-1 block w-full" required />
                                    <x-input-error :messages="$errors->get('name_on_card')" class="mt-2" />
                                </div>
                                
                                <div class="flex items-center justify-end mt-8">
                                    <x-primary-button>
                                        {{ __('Effectuer le paiement') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Récapitulatif de la réservation -->
                        <div class="bg-gray-50 p-6 rounded-lg self-start">
                            <h4 class="text-lg font-medium mb-4">Récapitulatif de la réservation</h4>
                            
                            <p class="mb-4 font-medium">{{ $booking->property->name }}</p>
                            
                            <div class="space-y-2 mb-6 text-sm">
                                <div class="flex justify-between">
                                    <span>Arrivée:</span>
                                    <span class="font-medium">{{ $booking->start_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Départ:</span>
                                    <span class="font-medium">{{ $booking->end_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Durée:</span>
                                    <span class="font-medium">{{ $booking->getNightsAttribute() }} nuit(s)</span>
                                </div>
                            </div>
                            
                            <div class="border-t pt-4 mt-4">
                                <h5 class="text-md font-medium mb-3">Détail des coûts</h5>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span>{{ $booking->getNightsAttribute() }} nuit(s) x {{ number_format($booking->property->price_per_night, 2) }} €</span>
                                        <span>{{ number_format($booking->getTotalPriceAttribute(), 2) }} €</span>
                                    </div>
                                </div>
                                
                                <div class="border-t mt-4 pt-4 flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span class="text-lg">{{ number_format($booking->getTotalPriceAttribute(), 2) }} €</span>
                                </div>
                            </div>
                            
                            <div class="mt-6 text-sm text-gray-600">
                                <p>Ce paiement est sécurisé et vos données sont protégées.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
