<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'artist_id',
        'amount',
        'payment_method',
        'payment_details',
        'status',
    ];

    /**
     * Relationship: A PayoutRequest belongs to an Artist.
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
