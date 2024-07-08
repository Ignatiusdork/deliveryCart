<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function placeOrder($items, $totalPrice)
    {
        dd($items);

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'Pending',
            'total' => $totalPrice,
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['item']->id,
                'quantity' => $item['quantity'],
                'price' => $item['item']->price,
        ]);

        //update product stock
        $product = Product::find($item['item']->id);
        $product->stock -= $item['quantity'];
        $product->save();

        }

        //dd($order);

        return $order;
    }

    public function getOrder($id)
    {
        return Order::with('orderItems.product')->findOrFail($id);
    }

    public function getUserOrders()
    {
        return Order::where('user_id', Auth::id())->get();
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        return $order;
    }

}
