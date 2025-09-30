<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'availability',
        'description',
        'images',
        'price',
        'living_space',
        'address',
        'completion_year',
        'floors',
        'bedrooms',
        'bathrooms',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Get the images attribute with full absolute URLs.
     */
    public function getImagesAttribute($value): array
    {
        $images = json_decode($value, true) ?? [];
        
        return array_map(function ($image) {
            // If the image is already a full URL, return as is
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            }
            
            // Convert relative path to absolute URL
            return asset('storage/' . $image);
        }, $images);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
