<div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
    <h2 class="text-lg font-bold mb-4 text-primary">
        <i class="fas fa-calendar-check mr-2"></i>
        Réserver cette propriété
    </h2>
    
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif
    
    @if (session()->has('warning'))
        <div class="bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded mb-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif
    
    <form wire:submit.prevent="book">
        <div class="mb-4">
            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-calendar-day mr-1 text-primary"></i>
                Date d'arrivée
            </label>
            <input type="date" 
                   id="startDate" 
                   wire:model.live="startDate" 
                   class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                   min="{{ now()->format('Y-m-d') }}">
            @error('startDate') 
                <span class="flex items-center text-red-500 text-sm mt-1">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </span> 
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">
                <i class="fas fa-calendar-day mr-1 text-primary"></i>
                Date de départ
            </label>
            <input type="date" 
                   id="endDate" 
                   wire:model.live="endDate" 
                   class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                   min="{{ $startDate ?: now()->addDay()->format('Y-m-d') }}">
            @error('endDate') 
                <span class="flex items-center text-red-500 text-sm mt-1">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    {{ $message }}
                </span> 
            @enderror
        </div>
        
        @error('dates') 
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-times-circle mr-2"></i>
                    <span>{{ $message }}</span>
                </div>
            </div> 
        @enderror
        
        @error('booking')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span>{{ $message }}</span>
                </div>
            </div>
        @enderror
        
        <div class="border-t border-gray-200 pt-4 mb-4">
            <div class="bg-gray-50 p-3 rounded">
                <div class="flex justify-between items-center font-bold text-lg">
                    <span class="text-gray-700">Total :</span>
                    {{-- computed property pour mise à jour temps réel --}}
                    <span class="text-primary">{{ number_format($this->calculatedTotal, 2, ',', ' ') }} €</span>
                </div>
                @if($this->calculatedTotal > 0)
                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ number_format($property->price_per_night, 2, ',', ' ') }} € × 
                        {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) }} 
                        {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) > 1 ? 'nuits' : 'nuit' }}
                    </div>
                @endif
            </div>
        </div>
        
        @guest
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Vous devez être connecté pour effectuer une réservation.</span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium underline">
                        Se connecter
                    </a>
                    <span class="mx-2">ou</span>
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium underline">
                        Créer un compte
                    </a>
                </div>
            </div>
        @endguest
        
        <button type="submit" 
                class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-opacity-90 transition duration-200 font-medium flex items-center justify-center"
                @guest disabled @endguest>
            <i class="fas fa-credit-card mr-2"></i>
            @auth
                Confirmer la réservation
            @else
                Connectez-vous pour réserver
            @endauth
        </button>
    </form>
    
    <div class="mt-4 text-xs text-gray-500 text-center">
        <i class="fas fa-shield-alt mr-1"></i>
        Réservation sécurisée • Annulation gratuite sous 24h
    </div>
</div>
