<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        //retrieve the product from the database
        $product = Product::find($id);

        //get old cart data from the session or initialize a new array
        $oldCart = Session::get('cart', []);

        // Initialize the Cart model with old cart data
        $cart = new Cart($oldCart);
        $cart->loadFromSession();

        // add the product to the cart
        $cart->add(['id' => $product->id, 'price' => $product->price, 'name' =>  $product->name]);

        //save the update cart back to the session
        Session::put('cart', $cart->items);
    }
}
