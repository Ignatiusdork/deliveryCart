<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        //dd('Place Order Method Hit', $request->all());

        $items = session()->get('cart', []);

        //dd($items); // Dump the cart contents here

        if (empty($items)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }

        try

        {
            $order = $this->orderService->placeOrder($items);

            $this->cartService->clear();

            // Redirect to the order detail page, assuming 'orders.show' route expects an order ID
            return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully');

        } catch (\Exception $e) {
            Log::error('Error placing order: ' . $e->getMessage());

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

    //list orders
    public function listOrders()
    {
        $orders = $this->orderService->getUserOrders();

        return view('orders.index', compact('orders'));
    }

    public function markAsShipped($orderId)
    {
        $order = $this->orderService->updateOrderStatus($orderId, 'shipped');
        return redirect()->route('orders.index')->with('success', 'Order marked as shipped');
    }

    public function markAsDelivered($orderId)
    {
        $order = $this->orderService->updateOrderStatus($orderId, 'delivered');
        return redirect()->route('orders.index')->with('success', 'Order marked as delivered');
    }

    public function update(Request $request, $orderId)
    {
        $status = $request->input('status');
        $order = $this->orderService->updateOrderStatus($orderId, $status);

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully');
    }

    public function downloadInvoice($invoiceId) {
        return $this->orderService->downloadInvoice($invoiceId);
    }
}
