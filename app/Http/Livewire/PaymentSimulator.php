<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;

class PaymentSimulator extends Component
{
    public Booking $booking;
    public $cardNumber;
    public $expiryDate;
    public $cvv;
    
    protected $rules = [
        'cardNumber' => 'required|string|min:16|max:19',
        'expiryDate' => 'required|string|size:5',
        'cvv' => 'required|string|size:3',
    ];
    
    public function processPayment()
    {
        $this->validate();
        
        // Simulation de paiement réussi
        $this->booking->update(['payment_status' => 'paid']);
        
        session()->flash('message', 'Paiement effectué avec succès!');
        
        return redirect()->route('profile.bookings');
    }
    
    public function render()
    {
        return view('livewire.payment-simulator');
    }
}

// Ajouter une colonne payment_status dans la table bookings
// Créer une migration:
// php artisan make:migration add_payment_status_to_bookings_table
