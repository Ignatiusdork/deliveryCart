<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartService
{
    protected $items = [];
    protected $sessionKey = 'cart';

    public function __construct()
    {
        $this->loadFromSession();
    }

    public function add(Product $product, int $quantity = 1)
    {
        $id = $product->id;
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] += $quantity;
        } else {
            $this->items[$id] = ['item' => $product, 'quantity' => $quantity];
        }

        $this->saveSession();
    }
}
