<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes réservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @forelse ($bookings as $booking)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg font-medium">{{ $booking->property->name }}</h3>
                            <p class="text-gray-600">
                                Du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} 
                                au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                            </p>
                            <p class="mt-2">
                                <span class="font-bold">{{ $booking->nights }} nuits</span> • 
                                <span class="font-bold">Total: {{ number_format($booking->total_price, 2) }} €</span>
                            </p>
                            <p class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $booking->payment_status === 'paid' ? 'Payé' : 'En attente de paiement' }}
                                </span>
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:space-x-2 space-y-2 sm:space-y-0">
                            @if($booking->payment_status === 'pending')
                                <a href="{{ route('bookings.payment', $booking) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                                    {{ __('Payer maintenant') }}
                                </a>
                            @endif
                            
                            @if($booking->isEditable())
                                <a href="{{ route('bookings.edit', $booking) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                                    {{ __('Modifier') }}
                                </a>
                                
                                <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                                        {{ __('Annuler') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p>Vous n'avez pas encore effectué de réservation.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
