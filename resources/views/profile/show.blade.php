<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Informations personnelles') }}</h3>
                        <a href="{{ route('profile.edit') }}" class="text-primary hover:underline text-sm">
                            {{ __('Modifier') }}
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">{{ __('Nom') }}</p>
                            <p class="font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">{{ __('Email') }}</p>
                            <p class="font-medium">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Mes réservations') }}</h3>
                    
                    @forelse($bookings as $booking)
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-lg">{{ $booking->property->name }}</h4>
                                    <p class="text-gray-600">
                                        Du {{ $booking->start_date->format('d/m/Y') }} 
                                        au {{ $booking->end_date->format('d/m/Y') }}
                                    </p>
                                </div>
                                <span class="text-primary font-medium">
                                    {{ number_format($booking->property->price_per_night * $booking->start_date->diffInDays($booking->end_date), 2) }} €
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Vous n'avez pas encore de réservation.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
