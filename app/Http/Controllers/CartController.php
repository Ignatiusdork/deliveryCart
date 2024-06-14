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

        $cart = new Cart(
            $oldCart? : [],
            false,
        );

        $cart->add(array());
    }
}
