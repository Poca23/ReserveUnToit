<div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
    <h2 class="text-lg font-bold mb-4">Réserver cette propriété</h2>
    
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif
    
    <form wire:submit.prevent="book">
        <div class="mb-4">
            <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Date d'arrivée</label>
            <input type="date" id="startDate" wire:model="startDate" 
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Date de départ</label>
            <input type="date" id="endDate" wire:model="endDate" 
                class="w-full rounded-md shadow-sm border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
            @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        @error('dates') <div class="text-red-500 text-sm mb-4">{{ $message }}</div> @enderror
        
        <div class="border-t border-gray-200 pt-4 mb-4">
            <div class="flex justify-between font-bold">
                <span>Total :</span>
                <span>{{ number_format($total, 2) }} €</span>
            </div>
            <div class="text-xs text-gray-500 mt-1">
                {{ $property->price_per_night }} € x {{ Carbon\Carbon::parse($startDate)->diffInDays(Carbon\Carbon::parse($endDate)) }} nuits
            </div>
        </div>
        
        <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded hover:bg-opacity-90 transition">
            Réserver maintenant
        </button>
    </form>
</div>
