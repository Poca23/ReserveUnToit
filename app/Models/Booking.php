<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'property_id', 
        'start_date', 
        'end_date',
        'payment_status'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
    /**
     * Calcule le nombre de nuits entre la date de début et la date de fin
     * 
     * @return int
     */
    public function getNightsAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        
        return $this->start_date->diffInDays($this->end_date);
    }
    
    /**
     * Calcule le prix total de la réservation en fonction du prix par nuit
     * 
     * @return float
     */
    public function getTotalPriceAttribute()
    {
        if (!$this->property) {
            return 0;
        }
        
        return $this->property->price_per_night * $this->nights;
    }
    
    /**
     * Détermine si la réservation peut être annulée
     * Pour le test, permettre l'annulation si la réservation est en attente de paiement.
     * 
     * @return bool
     */
    public function isCancelable()
    {
        // Si la réservation est en attente de paiement, on peut l'annuler
        if ($this->payment_status === 'pending') {
            return true;
        }
        
        // Sinon, on vérifie la règle des 48h
        return $this->start_date && $this->start_date->subDays(2)->isAfter(now());
    }
    
    /**
     * Détermine si la réservation peut être modifiée
     * 
     * @return bool
     */
    public function isEditable()
    {
        // Si la réservation est en attente de paiement, on peut la modifier
        if ($this->payment_status === 'pending') {
            return true;
        }
        
        return $this->start_date && $this->start_date->subDays(2)->isAfter(now());
    }
    
    /**
     * Vérifie si la réservation nécessite un paiement
     *
     * @return bool
     */
    public function needsPayment()
    {
        return $this->payment_status !== 'paid';
    }
}
