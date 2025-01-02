<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'regular_price',
        'fee',
        'price_with_fee',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
