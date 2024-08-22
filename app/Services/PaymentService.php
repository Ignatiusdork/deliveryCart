<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe;
use Stripe\Charge;

    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */

class PaymentService {
    
    protected $cartService;

    public function __construct(CartService $cartService) {
        $this->cartService = $cartService;
    }

    public function processStripePayment($total, $token)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => $total * 100,
            "currency" => "usd",
            "source" => $token,
            "description" => "Test payment from littcart2"
        ]);

        return true;
    }

    public function createOrder($total)
    {
        $items = $this->cartService->view();
        $userId = auth()->id();

        $order = Order::create([
            'user_id' => $userId,
            'total' => $total,
            'status' => 'Paid'
        ]);

        foreach ($items as $item)
        {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['item']->id,
                'quantity' => $items['quantity'],
                'price' => $item['item']
            ]);
        }

        // update product stock after all items has been ordered
        foreach ($items as $item) {
            $product = Product::find($item['item']->id);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        Session::flash('success', 'Payment Successfull!');
        return back();
    }
}
