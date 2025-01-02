<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function artist()
    {
        return $this->hasOneThrough(
            Artist::class,
            Product::class,
            'id',           // Foreign key on the products table
            'id',           // Foreign key on the artists table
            'product_id',   // Local key on the order_items table
            'artist_id'     // Local key on the products table
        );
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    

}