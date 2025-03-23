<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        // Nous n'avons pas besoin de passer les propriétés ici car le composant Livewire les récupère
        return view('properties.index');
    }
    
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }
}
