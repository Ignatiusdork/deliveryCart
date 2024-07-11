<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;

    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function placeOrder(Request $request)
    {

        $items = $this->cartService->view();

        if (empty($items)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }

        try {

            $order = $this->orderService->placeOrder();

            $this->cartService->clear();

            // Redirect to the order detail page, assuming 'orders.show' route expects an order ID
            return redirect()->route('orders.show', $order->id)->with('sucess', 'Order placed successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while placing the order.');
        }
    }

    public function showOrder($id)
    {
        $order = $this->orderService->getOrder($id);

        if ($order->user_id != Auth::id()) {
            return redirect()->route('welcome')->with('error', 'You do not have access to this order.');
        }

        return view('orders.show', compact('order'));
    }

    public function listOrders()
    {
        $orders = $this->orderService->getUserOrders();

        return view('orders.index', compact('orders'));
    }

    public function update(Request $request, $orderId)
    {
        $status = $request->input('status');
        $order = $this->orderService->updateOrderStatus($orderId, $status);

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully');
    }
}
