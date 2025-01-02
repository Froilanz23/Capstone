<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    protected $fillable = [
        'user_id',
        'subtotal',
        'discount',
        'tax',
        'total',
        'name',
        'phone',
        'house_number',
        'street',
        'barangay',
        'city',
        'state',
        'country',
        'zip_code',
        'shipping_option',
        'is_shipping_different',
        'status',
        'shipped_date',
        'delivered_date',
        'canceled_date',
        'tracking_number', // Add this
        'shipping_company', // Add this
    ];

}
