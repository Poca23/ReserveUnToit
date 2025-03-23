<!-- resources/views/bookings/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes réservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if($bookings->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($bookings as $booking)
                                <div class="border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="p-4 bg-white">
                                        <h3 class="text-lg font-bold mb-2">{{ $booking->property->name }}</h3>
                                        <p class="text-gray-600 mb-2">
                                            Du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} 
                                            au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                                        </p>
                                        <p class="mb-4">
                                            <span class="font-semibold">Statut:</span> 
                                            @if(isset($booking->payment_status) && $booking->payment_status === 'paid')
                                                <span class="text-green-600 font-semibold">Confirmé</span>
                                            @else
                                                <span class="text-orange-500 font-semibold">En attente de paiement</span>
                                            @endif
                                        </p>
                                        
                                        <div class="flex space-x-2 mt-4">
                                            <a href="{{ route('bookings.show', $booking) }}" 
                                               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                                Détails
                                            </a>
                                            
                                            @if($booking->isEditable())
                                                <a href="{{ route('bookings.edit', $booking) }}" 
                                                   class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                                    Modifier
                                                </a>
                                            @endif
                                            
                                            @if($booking->isCancelable())
                                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')"
                                                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                                        Annuler
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600 mb-4">Vous n'avez pas encore effectué de réservation.</p>
                            <a href="{{ route('properties.index') }}" 
                               class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                Explorer les propriétés
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
