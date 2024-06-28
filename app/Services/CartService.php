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

    public function remove(int $id)
    {
        if(isset($this->items[$id])) {
            unset($this->items[$id]);
            $this->saveSession();
        }
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->items as $cartItem) {
            $total += $cartItem['items']['price'] * $cartItem['quantity'];
        }
        return $total;
    }

    public function view()
    {
        return $this->items;
    }

    protected function saveSession()
    {
        session([$this->sessionKey => $this->items]);
    }

    //load cart data from the saved session
    protected function loadFromSession()
    {
        $this->items = session($this->sessionKey, []);
    }
}
