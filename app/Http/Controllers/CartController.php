<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function add(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        $quantity = $request->input('quantity', 1);
        $this->cartService->add($product, $quantity);

        dd(Session::get('cart'));
        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function remove(Request $request, $id)
    {
        $this->cartService->remove($id);

        return redirect()->back()->with('success', 'Product removed from cart sucessfully');
    }

    public function getTotal()
    {
        $total = $this->cartService->getTotal();

        return view('cart.total', compact('total'));
    }

    public function viewCart()
    {

        $items = $this->cartService->view();
        $total = $this->cartService->getTotal();

        return view('cart.view', compact('items', 'total'));
    }
}
