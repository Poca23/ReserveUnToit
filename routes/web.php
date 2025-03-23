<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route d'accueil avec le nouveau HomeController
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Routes pour les propriétés
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Routes pour les réservations (accessibles uniquement aux utilisateurs connectés)
Route::middleware('auth')->group(function() {
    // Affichage des réservations
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    
    // Création de réservation
    Route::post('/properties/{property}/book', [BookingController::class, 'store'])->name('bookings.store');
    
    // Paiement
    Route::get('/bookings/{booking}/payment', [BookingController::class, 'showPayment'])->name('bookings.payment');
    Route::post('/bookings/{booking}/payment', [BookingController::class, 'processPayment'])->name('bookings.process-payment');
    
    // Modification et annulation
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::patch('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Routes pour le profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route pour afficher les réservations dans le profil
    Route::get('/profile/bookings', [BookingController::class, 'index'])->name('profile.bookings');
});

require __DIR__.'/auth.php';
