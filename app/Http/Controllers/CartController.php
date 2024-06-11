<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        //retrieve the product from the database
        $product = \App\Models\Product::find($id);

        //store the product in the session
        $oldCart = Session::get('cart');

        // $cart = new \Cart(
        //     $oldCart? : [],
        //     false
        // );

        $cart->add(array());
    }
}
