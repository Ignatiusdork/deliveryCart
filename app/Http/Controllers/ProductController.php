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
}
