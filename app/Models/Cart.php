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
    public function add($item, $quantity =1)
    {
        $id = $item['id'];

        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] += $quantity;
        } else {
            $this->items[$id] = ['item' => $item, 'quantity' => $quantity];
        }

        $this->saveSession();
    }

    // remove item from cart
    public function remove($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
            $this->saveSession();
        }
    }

    //get total proce of the cart
    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $cartItems) {
            $total += $cartItems['items']['price'] * $cartItems['quantity'];
        }

        return $total;
    }

}
