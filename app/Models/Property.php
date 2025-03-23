<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price_per_night', 'image'];

    protected $appends = ['image_url', 'formatted_description'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Accesseur pour garantir une image par défaut si aucune URL n'est fournie
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Si l'image est une URL complète
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }

            // Si l'image est stockée dans le storage public
            if (Storage::disk('public')->exists($this->image)) {
                return Storage::url($this->image);
            }
        }

        // Image par défaut libre de droit
        return 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80';
    }
    
    // Dans le modèle Property
    public function getFormattedDescriptionAttribute()
    {
        return nl2br(e($this->description));
    }

    public function getImagePathDebug()
    {
        return "Image path: " . $this->image . " | Is URL: " . (filter_var($this->image, FILTER_VALIDATE_URL) ? 'Yes' : 'No');
    }
}
