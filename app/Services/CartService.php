<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Nette\InvalidArgumentException;

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

        $cart = Session::get($this->sessionKey, []);

        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = ['item' => $product, 'quantity' => $quantity];
        }

        Session::put($this->sessionKey, $cart);
    }

    public function remove(int $id)
    {
        $cart = Session::get($this->sessionKey, []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
        }
        Session::put($this->sessionKey, $cart);
    }

    public function getTotal(): float
    {
        $cart = Session::get($this->sessionKey, []);
        $total = 0;

        foreach ($cart as $cartItem) {
            $total += $cartItem['item']->price * $cartItem['quantity'];
        }
        return $total;
    }

    public function view(): array
    {
        $items = Session::get($this->sessionKey, []);

        return $items;
    }

    public function clear()
    {
        $this->items = [];
        $this->saveSession();
    }

    protected function saveSession()
    {
        Session::put($this->sessionKey, $this->items);
    }

    //load cart data from the saved session
    protected function loadFromSession()
    {
        $this->items = Session::get($this->sessionKey, []);
    }
}
