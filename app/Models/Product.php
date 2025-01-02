<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'regular_price',
        'dimensions',
        'year_created',

        'category_id',
        'artist_id',

        'medium',
        'style',
        'subject',
        'material',

        'featured',
        'COA',
        'framed',
        'signature',

        'image',
        'images',

        'updated_at',
    ];


// In Product.php
// In your Product model

            public function ratings()
            {
                return $this->hasMany(ProductRating::class);
            }

            public function category()
            {
                return $this->belongsTo(Category::class);
            }


            public function artist()
            {
                return $this->belongsTo(Artist::class, 'artist_id');
            }
            
            public function orderItems()
            {
                return $this->hasMany(OrderItem::class, 'product_id');
            }

            public function productFee()
            {
                return $this->hasOne(ProductFee::class);
            }


            

}
