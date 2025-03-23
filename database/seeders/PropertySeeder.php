<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $properties = [
            [
                'name' => 'Villa Vue sur Mer',
                'description' => 'Magnifique villa avec vue panoramique sur la mer. Piscine privée, 4 chambres, terrasse ensoleillée.',
                'price_per_night' => 250.00,
                'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Chalet Alpin',
                'description' => 'Charmant chalet au cœur des montagnes. Parfait pour les amateurs de ski et de randonnée.',
                'price_per_night' => 180.00,
                'image' => 'https://images.unsplash.com/photo-1542718610-a1d656d1884c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Appartement Centre-Ville',
                'description' => 'Appartement moderne situé en plein centre-ville. À proximité des restaurants, bars et attractions touristiques.',
                'price_per_night' => 120.00,
                'image' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Maison de Campagne',
                'description' => 'Une maison paisible à la campagne, idéale pour se détendre et profiter de la nature.',
                'price_per_night' => 150.00,
                'image' => 'https://images.unsplash.com/photo-1510798831971-661eb04b3739?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80',
            ],
            [
                'name' => 'Loft Industriel',
                'description' => 'Grand loft de style industriel avec plafonds hauts et grandes fenêtres. Design contemporain.',
                'price_per_night' => 200.00,
                'image' => 'https://cdn.pixabay.com/photo/2016/11/18/14/05/brick-wall-1834784_1280.jpg',
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }
    }
}
