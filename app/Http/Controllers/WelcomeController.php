<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Récupérer les propriétés en vedette (4 maximum)
        $featuredProperties = Property::inRandomOrder()->take(4)->get();
        
        // Destinations populaires avec image corrigée pour Lyon
        $popularDestinations = [
            ['name' => 'Paris', 'count' => 15, 'image' => 'https://images.pexels.com/photos/699466/pexels-photo-699466.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'], // Tour Eiffel
            ['name' => 'Nice', 'count' => 8, 'image' => 'https://pixabay.com/get/g901a7c10de18ca84f18b08639265e57d5c0317eba452269e34ddb1faf7b196d510587146648001bab8f9fcb8ed0b8a50.jpg'], // Mer
            ['name' => 'Bordeaux', 'count' => 12, 'image' => 'https://cdn.pixabay.com/photo/2022/05/09/08/15/building-7183984_960_720.jpg'], // Place de la Bourse et miroir d'eau
            ['name' => 'Lyon', 'count' => 10, 'image' => 'https://pixabay.com/get/gb769fecc9e0c753e3af3b752d3e5966649b0fedf8179429b92f06e59205ad39513be77a8007a049e1da8432ddc3d7b5aac2da533ab1acdf6a57e71ff67515614_1920.jpg'], // 
            ['name' => 'Marseille', 'count' => 9, 'image' => 'https://pixabay.com/get/g4046e7f12d037f061eb504d950ff893ec87425dff481e7e4f60ec58cf01923c62a17dbccb4d55c642adc62be325963aa.jpg'], // Calanques
            ['name' => 'Strasbourg', 'count' => 6, 'image' => 'https://pixabay.com/get/g4ab99170acd9640218410f1508ef9ef0f2f74d95cb51e9a0f2d2f485dc1ec43dccb2246407fbb1320b8f0c0fcc5153b6.jpg'] // Canal
        ];
        
        // Témoignages avec URLs d'avatars directes
        $testimonials = [
            ['name' => 'Sophie M.', 'rating' => 5, 'comment' => "Un séjour parfait dans un appartement magnifique. Je recommande !", 'date' => '15/04/2023', 'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Marc D.', 'rating' => 4, 'comment' => "Très bonne expérience, propriétaire réactif et logement confortable.", 'date' => '23/05/2023', 'avatar' => 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80'],
            ['name' => 'Julie L.', 'rating' => 5, 'comment' => "Emplacement idéal et prestations de qualité. Nous reviendrons !", 'date' => '07/06/2023', 'avatar' => 'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80']
        ];
        
        // Image placeholder pour les propriétés sans photo
        $propertyPlaceholder = 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80';
        
        return view('welcome', compact('featuredProperties', 'popularDestinations', 'testimonials', 'propertyPlaceholder'));
    }
}
