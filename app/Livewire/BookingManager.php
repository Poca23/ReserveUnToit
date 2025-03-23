<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Property;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingManager extends Component
{
    public Property $property;
    public $startDate;
    public $endDate;
    
    protected $rules = [
        'startDate' => 'required|date|after_or_equal:today',
        'endDate' => 'required|date|after:startDate',
    ];
    
    public function mount(Property $property)
    {
        $this->property = $property;
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(1)->format('Y-m-d');
    }
    
    public function calculateTotal()
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }
        
        $start = new Carbon($this->startDate);
        $end = new Carbon($this->endDate);
        $days = $end->diffInDays($start);
        
        return $days * $this->property->price_per_night;
    }
    
    public function book()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $this->validate();
        
        // Vérifier disponibilité
        $conflictingBookings = Booking::where('property_id', $this->property->id)
            ->where(function($query) {
                $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                    ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                    ->orWhere(function($query) {
                        $query->where('start_date', '<=', $this->startDate)
                            ->where('end_date', '>=', $this->endDate);
                    });
            })
            ->count();
        
        if ($conflictingBookings > 0) {
            $this->addError('dates', 'Ces dates ne sont pas disponibles.');
            return;
        }
        
        Booking::create([
            'property_id' => $this->property->id,
            'user_id' => Auth::id(),
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
        
        session()->flash('message', 'Votre réservation a été enregistrée avec succès !');
        
        $this->reset(['startDate', 'endDate']);
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(1)->format('Y-m-d');
        
        $this->dispatch('booking-created');
    }
    
    public function render()
    {
        return view('livewire.booking-manager', [
            'total' => $this->calculateTotal(),
        ]);
    }
}
