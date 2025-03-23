<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;

class PropertySearch extends Component
{
    public $search = '';
    public $minPrice = null;
    public $maxPrice = null;
    
    public function render()
    {
        return view('livewire.property-search', [
            'properties' => Property::query()
                ->when($this->search, fn($query) => 
                    $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                )
                ->when($this->minPrice, fn($query) => 
                    $query->where('price_per_night', '>=', $this->minPrice)
                )
                ->when($this->maxPrice, fn($query) => 
                    $query->where('price_per_night', '<=', $this->maxPrice)
                )
                ->get(),
        ]);
    }
}
