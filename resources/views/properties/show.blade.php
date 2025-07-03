<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $property->name }}
            </h2>
            <a href="{{ route('properties.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <div class="h-64 bg-gray-100 rounded-lg mb-4 overflow-hidden">
                                <img src="{{ $property->image_url }}" alt="{{ $property->name }}" class="w-full h-full object-cover">
                            </div>
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $property->name }}</h1>
                            <div class="text-gray-600 mb-4 prose max-w-none">
                                {!! $property->formatted_description !!}
                            </div>
                            <div class="text-xl font-bold text-primary mb-6">
                                {{ number_format($property->price_per_night, 2) }} € / nuit
                            </div>
                            
                            @livewire('availability-calendar', ['property' => $property])
                        </div>
                        
                        <div class="md:col-span-1">
                            @livewire('booking-manager', ['property' => $property])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
