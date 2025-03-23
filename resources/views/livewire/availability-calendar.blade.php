<div>
    <h3 class="text-lg font-bold mb-3">Disponibilités</h3>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="flex justify-between items-center p-3 border-b border-gray-200">
            <button wire:click="prevMonth" class="text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            <h4 class="font-medium">{{ $monthName }}</h4>
            <button wire:click="nextMonth" class="text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-7 gap-px">
            <div class="text-center py-2 text-xs font-medium text-gray-500">L</div>
            <div class="text-center py-2 text-xs font-medium text-gray-500">M</div>
            <div class="text-center py-2 text-xs font-medium text-gray-500">M</div>
            <div class="text-center py-2 text-xs font-medium text-gray-500">J</div>
            <div class="text-center py-2 text-xs font-medium text-gray-500">V</div>
            <div class="text-center py-2 text-xs font-medium text-gray-500">S</div>
            <div class="text-center py-2 text-xs font-medium text-gray-500">D</div>
            
            @foreach ($calendar as $day)
                <div 
                    class="relative h-10 border-t border-gray-100 p-1 text-center
                        {{ !$day['isCurrentMonth'] ? 'bg-gray-50 text-gray-400' : '' }}
                        {{ $day['isPast'] ? 'bg-gray-100' : '' }}
                        {{ $day['isBooked'] ? 'bg-primary bg-opacity-10' : '' }}
                    "
                >
                    <span class="text-sm {{ $day['isBooked'] ? 'text-primary font-bold' : '' }}">
                        {{ $day['day'] }}
                    </span>
                    
                    @if($day['isBooked'])
                        <span class="absolute bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-primary rounded-full"></span>
                    @endif
                </div>
            @endforeach
        </div>
        
        <div class="p-3 border-t border-gray-200 text-xs flex items-center">
            <span class="inline-block w-3 h-3 bg-primary bg-opacity-10 border border-primary rounded-full mr-1"></span>
            <span class="text-gray-600">Réservé</span>
        </div>
    </div>
</div>
