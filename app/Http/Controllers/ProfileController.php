<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Afficher les informations et les réservations de l'utilisateur
     */
    public function show(): View
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)
                    ->with('property')
                    ->latest()
                    ->get();
                    
        return view('profile.show', compact('user', 'bookings'));
    }

    /**
     * Affiche toutes les réservations de l'utilisateur connecté
     * avec options de gestion (modification, annulation)
     */
    public function bookings(): View
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)
                    ->with('property')
                    ->latest()
                    ->get();
                    
        return view('profile.bookings', compact('bookings'));
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function update(Request $request)
    {
        // Logique de mise à jour du profil
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function destroy(Request $request)
    {
        // Logique de suppression du compte
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
