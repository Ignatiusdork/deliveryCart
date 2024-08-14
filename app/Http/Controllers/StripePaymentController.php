<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function stripe($total)
    {
        return view('stripe.show', compact("total"));
    }

    public function stripePost(Request $request, $total)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $total * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Test payment from littcart"
        ]);

       // Fetch cart items from CartService and the totalprice
       $items = $this->cartService->view();
       $totalPrice = $this->cartService->getTotal();

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'Paid',
            'total' => $totalPrice,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['item']->id,
                'quantity' => $item['quantity'],
                'price' => $item['item']->price,
            ]);
        }

        // Update product stock after all items have been ordered
        foreach ($items as $item) {
            $product = Product::find($item['item']->id);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        Session::flash('success', 'Payment successful!');

        return back();
    }
}
