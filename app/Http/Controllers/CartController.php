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

        // get the quantity from the request
        $quantity = $request->input('quantity', 1);

        // add the product to the cart
        $cart->add(['id' => $product->id, 'price' => $product->price, 'name' =>  $product->name, 'description' => $product->description], $quantity);
        Session::put('cart', $cart->items);

        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function remove(Request $request, $id)
    {
        $oldcart = Session::get('cart', []);
        $cart = new Cart($oldcart);
        $cart->loadFromSession();
        $cart->remove($id);
        Session::put('cart', $cart->items);

        return redirect()->back()->with('success', 'Product removed from cart sucessfully');
    }

    public function getTotal()
    {
        $oldCart = Session::get('cart', []);
        $cart = new Cart($oldCart);
        $cart->loadFromSession();

        $total = $cart->getTotal();

        return view('cart.total', compact('total'));
    }

    public function viewCart()
    {
        $oldCart = Session::get('cart', []);
        $cart = new Cart($oldCart);
        $cart->loadFromSession();

        $items = $cart->view();

        return view('cart.view', compact('items'));
    }
}
