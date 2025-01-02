<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'image',
        'workplace_photo',
        'artist_category',
        'legal_name',
        'email',
        'artist_description',
        'portfolio_url',
        'city',
        'province',
        'valid_id',
        'verification_status',
        'updated_at',
    ];

    /**
     * Default attributes.
     */
    protected $attributes = [
        'verification_status' => 'pending',
    ];

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Products.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'artist_id');
    }
    

    /**
     * Accessor for verification status.
     */
    public function getIsVerifiedAttribute()
    {
        return $this->verification_status === 'approved';
    }

        // In your User model

    public function artist()
    {
        return $this->hasOne(Artist::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    public function availableArtworksCount()
{
    return $this->products()->where('is_sold', false)->count();
}

}
