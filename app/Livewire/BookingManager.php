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

    protected $messages = [
        'startDate.required' => 'La date d\'arrivée est obligatoire.',
        'startDate.date' => 'La date d\'arrivée doit être une date valide.',
        'startDate.after_or_equal' => 'La date d\'arrivée ne peut pas être antérieure à aujourd\'hui.',
        'endDate.required' => 'La date de départ est obligatoire.',
        'endDate.date' => 'La date de départ doit être une date valide.',
        'endDate.after' => 'La date de départ doit être postérieure à la date d\'arrivée.',
    ];

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(1)->format('Y-m-d');
    }

    // property pour mise à jour automatique
    public function getCalculatedTotalProperty()
    {
        if (!$this->startDate || !$this->endDate) {
            return 0;
        }

        $start = new Carbon($this->startDate);
        $end = new Carbon($this->endDate);
        $days = $start->diffInDays($end);

        return $days * $this->property->price_per_night;
    }

    // méthode originale pour compatibilité
    public function calculateTotal()
    {
        return $this->getCalculatedTotalProperty();
    }

    public function book()
    {
        if (!Auth::check()) {
            session()->flash('warning', 'Vous devez être connecté pour effectuer une réservation.');
            return redirect()->route('login');
        }

        $this->validate();

        $conflictingBookings = Booking::where('property_id', $this->property->id)
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                    ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                    ->orWhere(function ($query) {
                        $query->where('start_date', '<=', $this->startDate)
                            ->where('end_date', '>=', $this->endDate);
                    });
            })
            ->count();

        if ($conflictingBookings > 0) {
            $this->addError('dates', 'Ces dates ne sont pas disponibles. Veuillez choisir d\'autres dates.');
            return;
        }

        try {
            Booking::create([
                'property_id' => $this->property->id,
                'user_id' => Auth::id(),
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]);

            session()->flash('message', 'Félicitations ! Votre réservation a été confirmée avec succès.');

            $this->reset(['startDate', 'endDate']);
            $this->startDate = now()->format('Y-m-d');
            $this->endDate = now()->addDays(1)->format('Y-m-d');

            $this->dispatch('booking-created');

        } catch (\Exception $e) {
            $this->addError('booking', 'Une erreur est survenue lors de la réservation. Veuillez réessayer.');
        }
    }

    public function render()
    {
        return view('livewire.booking-manager');
    }
}
