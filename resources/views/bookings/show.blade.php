<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de la réservation') }}
            </h2>
            <a href="{{ route('bookings.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Informations propriété -->
                        <div class="lg:col-span-2">
                            <h3 class="text-xl font-semibold mb-4">{{ $booking->property->name }}</h3>
                            <p class="text-gray-600 mb-6">{{ $booking->property->description }}</p>
                            
                            <div class="border-t pt-6 mt-6">
                                <h4 class="text-lg font-medium mb-4">Détails de la réservation</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded">
                                        <p class="text-sm text-gray-600">Date d'arrivée</p>
                                        <p class="font-medium">{{ $booking->start_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded">
                                        <p class="text-sm text-gray-600">Date de départ</p>
                                        <p class="font-medium">{{ $booking->end_date->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded">
                                        <p class="text-sm text-gray-600">Durée du séjour</p>
                                        <p class="font-medium">{{ $booking->getNightsAttribute() }} nuit(s)</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded">
                                        <p class="text-sm text-gray-600">Réservé le</p>
                                        <p class="font-medium">{{ $booking->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded col-span-2">
                                        <p class="text-sm text-gray-600">Statut</p>
                                        <p class="font-medium">
                                            @if(isset($booking->payment_status) && $booking->payment_status === 'paid')
                                                <span class="text-green-600 font-semibold">Confirmé</span>
                                            @else
                                                <span class="text-orange-500 font-semibold">En attente de paiement</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Récapitulatif -->
                        <div class="bg-gray-50 p-6 rounded-lg self-start">
                            <h4 class="text-lg font-medium mb-4">Récapitulatif des coûts</h4>
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between">
                                    <span>Prix par nuit</span>
                                    <span>{{ number_format($booking->property->price_per_night, 2) }} €</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Nombre de nuits</span>
                                    <span>{{ $booking->getNightsAttribute() }}</span>
                                </div>
                                <div class="pt-3 border-t flex justify-between font-semibold">
                                    <span>Total</span>
                                    <span>{{ number_format($booking->property->price_per_night * $booking->getNightsAttribute(), 2) }} €</span>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-4 border-t">
                                <p class="text-sm text-gray-600 mb-1">Référence de réservation</p>
                                <p class="font-mono font-medium">#{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action - Placés en bas pour plus de visibilité -->
                    <div class="mt-8 flex flex-wrap gap-3">
                        @if($booking->payment_status !== 'paid')
                            <a href="{{ route('bookings.payment', $booking) }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Procéder au paiement
                            </a>
                            
                            @if($booking->isEditable())
                                <a href="{{ route('bookings.edit', $booking) }}" 
                                class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Modifier la réservation
                                </a>
                            @else
                                <button type="button" 
                                    id="editRestrictionBtn"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Modifier la réservation
                                </button>
                            @endif
                            
                            @if($booking->isCancelable())
                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')"
                                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Annuler la réservation
                                    </button>
                                </form>
                            @else
                                <button type="button" 
                                    id="cancelRestrictionBtn"
                                    class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Annuler la réservation
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de restriction de modification -->
    <div id="editRestrictionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-lg bg-white shadow-xl transition-all">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Modification impossible</h3>
                        <button type="button" class="modal-close text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center">
                            <p class="text-sm text-gray-600">
                                La modification n'est plus possible car votre séjour débute dans moins de 48 heures.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="button" class="modal-close w-full mt-3 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                            Compris
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de restriction d'annulation -->
    <div id="cancelRestrictionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-lg bg-white shadow-xl transition-all">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Annulation impossible</h3>
                        <button type="button" class="modal-close text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Fermer</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-3">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center">
                            <p class="text-sm text-gray-600">
                                L'annulation n'est plus possible car votre séjour débute dans moins de 48 heures.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="button" class="modal-close w-full mt-3 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                            Compris
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript pour les modales -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Boutons qui ouvrent les modales
            const editRestrictionBtn = document.getElementById('editRestrictionBtn');
            const cancelRestrictionBtn = document.getElementById('cancelRestrictionBtn');
            
            // Modales
            const editRestrictionModal = document.getElementById('editRestrictionModal');
            const cancelRestrictionModal = document.getElementById('cancelRestrictionModal');
            
            // Boutons de fermeture dans les modales
            const closeButtons = document.querySelectorAll('.modal-close');
            
            if (editRestrictionBtn) {
                editRestrictionBtn.addEventListener('click', function() {
                    editRestrictionModal.classList.remove('hidden');
                });
            }
            
            if (cancelRestrictionBtn) {
                cancelRestrictionBtn.addEventListener('click', function() {
                    cancelRestrictionModal.classList.remove('hidden');
                });
            }
            
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    editRestrictionModal.classList.add('hidden');
                    cancelRestrictionModal.classList.add('hidden');
                });
            });
            
            // Fermer la modale en cliquant à l'extérieur
            window.addEventListener('click', function(e) {
                if (e.target === editRestrictionModal || e.target === cancelRestrictionModal) {
                    editRestrictionModal.classList.add('hidden');
                    cancelRestrictionModal.classList.add('hidden');
                }
            });
            
            // Fermer la modale avec la touche Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    editRestrictionModal.classList.add('hidden');
                    cancelRestrictionModal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
