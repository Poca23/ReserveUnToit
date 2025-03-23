<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Afficher toutes les réservations de l'utilisateur connecté
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('property')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }
    
    /**
     * Afficher le détail d'une réservation
     */
    public function show(Booking $booking)
    {
        // Vérifier que l'utilisateur est bien le propriétaire de la réservation
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('bookings.show', compact('booking'));
    }
    
    /**
     * Créer une nouvelle réservation
     */
    public function store(Request $request, Property $property)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        // Vérifier que la période n'est pas déjà réservée
        $overlappingBookings = Booking::where('property_id', $property->id)
            ->where(function($query) use ($validatedData) {
                $query->whereBetween('start_date', [$validatedData['start_date'], $validatedData['end_date']])
                    ->orWhereBetween('end_date', [$validatedData['start_date'], $validatedData['end_date']])
                    ->orWhere(function($q) use ($validatedData) {
                        $q->where('start_date', '<=', $validatedData['start_date'])
                          ->where('end_date', '>=', $validatedData['end_date']);
                    });
            })
            ->exists();
        
        if ($overlappingBookings) {
            return back()->withErrors(['dates' => 'Cette période est déjà réservée.']);
        }
        
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->property_id = $property->id;
        $booking->start_date = $validatedData['start_date'];
        $booking->end_date = $validatedData['end_date'];
        
        // Vérifier si la colonne payment_status existe avant d'essayer de l'utiliser
        if (Schema::hasColumn('bookings', 'payment_status')) {
            $booking->payment_status = 'pending';
        }
        
        $booking->save();
        
        return redirect()->route('bookings.payment', $booking)
            ->with('success', 'Votre réservation a été créée avec succès. Veuillez effectuer le paiement.');
    }
    
    /**
     * Afficher le formulaire de paiement
     */
    public function showPayment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('bookings.payment', compact('booking'));
    }
    
    /**
     * Traiter le paiement
     */
    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validatedData = $request->validate([
            'card_number' => 'required|string|min:16|max:19',
            'expiry_date' => 'required|string|size:5',
            'cvv' => 'required|string|size:3',
        ]);
        
        // Vérifier si la colonne payment_status existe
        if (Schema::hasColumn('bookings', 'payment_status')) {
            // Si elle existe, mettre à jour le statut de paiement
            $booking->payment_status = 'paid';
            $booking->save();
        } else {
            // Si elle n'existe pas, stocker l'information de paiement ailleurs
            // Par exemple, on pourrait utiliser une table de transactions séparée
            // ou mettre à jour une propriété métadonnée JSON
            
            // Pour cet exemple simple, on peut juste simuler que le paiement a été effectué
            // sans rien enregistrer en base de données
            // Vous pourriez remplacer ceci par une logique d'enregistrement alternative
        }
        
        return redirect()->route('profile.bookings')
            ->with('success', 'Votre paiement a été effectué avec succès. Votre réservation est confirmée.');
    }
    
    /**
     * Afficher le formulaire de modification
     */
    public function edit(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        if (!$booking->isEditable()) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Cette réservation ne peut plus être modifiée car votre séjour débute dans moins de 48 heures.');
        }
        
        return view('bookings.edit', compact('booking'));
    }
    
    /**
     * Mettre à jour une réservation
     */
    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        if (!$booking->isEditable()) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Cette réservation ne peut plus être modifiée car votre séjour débute dans moins de 48 heures.');
        }
        
        $validatedData = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        // Vérifier que la nouvelle période n'est pas déjà réservée
        $overlappingBookings = Booking::where('property_id', $booking->property_id)
            ->where('id', '!=', $booking->id)
            ->where(function($query) use ($validatedData) {
                $query->whereBetween('start_date', [$validatedData['start_date'], $validatedData['end_date']])
                    ->orWhereBetween('end_date', [$validatedData['start_date'], $validatedData['end_date']])
                    ->orWhere(function($q) use ($validatedData) {
                        $q->where('start_date', '<=', $validatedData['start_date'])
                          ->where('end_date', '>=', $validatedData['end_date']);
                    });
            })
            ->exists();
        
        if ($overlappingBookings) {
            return back()->withErrors(['dates' => 'Cette période est déjà réservée.']);
        }
        
        $booking->start_date = $validatedData['start_date'];
        $booking->end_date = $validatedData['end_date'];
        $booking->save();
        
        return redirect()->route('profile.bookings')
            ->with('success', 'Votre réservation a été modifiée avec succès.');
    }
    
    /**
     * Annuler une réservation
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        if (!$booking->isCancelable()) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Cette réservation ne peut plus être annulée car votre séjour débute dans moins de 48 heures.');
        }
        
        $booking->delete();
        
        return redirect()->route('profile.bookings')
            ->with('success', 'Votre réservation a été annulée avec succès.');
    }
}
