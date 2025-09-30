<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    /** @use HasFactory<\Database\Factories\BrokerFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'role',
        'about',
        'experience',
        'phone',
        'email',
        'residence',
        'x',
        'linkedin',
    ];

    /**
     * Get the image attribute with full absolute URL.
     */
    public function getImageAttribute($value): string
    {
        // If the image is already a full URL, return as is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        
        // Convert relative path to absolute URL
        return asset('storage/' . $value);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
