<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {

        $query = Product::query();

        return view('profile.index',
            ['products' => Product::latest()
            ->paginate(6),
        ]);
    }

    public function show($productId) {
        $product = Product::findOrFail($productId);
        return view('products.show', compact('product'));
    }
}
