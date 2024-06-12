<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function __construct(array $items = [], $sessionKey = 'cart')
    {
        $this->items = $items;
        $this->sessionKey = $sessionKey;
    }

    // relationsip between users and items in the cart
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(CartItem::class);
    }

    // Add items to cart
    public function add($item, $quantity =1) {

    }
}
