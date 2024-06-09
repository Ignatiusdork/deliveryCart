<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        //retrieve the product from the database
        $product = \App\Models\Product::find($id);
    }
}
