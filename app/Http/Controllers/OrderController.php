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

    public function placeOrder(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;

        $items = $this->cartService->view();
        if (count($items) == 0) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }

        $totalPrice = $this->cartService->getTotal();

        try {
            $order = $this->orderService->placeOrder(Auth::user()->id, $totalPrice);

            // Clear the cart
            $this->cartService->clear();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully');
            
        } catch (\Exception $e) {
            // Log the exception or show an error page
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
