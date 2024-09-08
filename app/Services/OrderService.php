<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function placeOrder()
    {
       // Fetch cart items from CartService and the totalprice
       $items = $this->cartService->view();
       $totalPrice = $this->cartService->getTotal();

       // handle if cart is empty
       if (empty($items)) {
        return null;
       }

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
        }

        // Update product stock after all items have been ordered
        foreach ($items as $item) {
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
        $order->update(['status' => $status]);

        return $order;
    }

    public function downloadInvoice($invoiceId) {

        $invoice = Invoice::findOrFail($invoiceId);

        //prepare invoice data
        $data = [
            'invoice' => $invoice,
            'order' => $invoice->order,
            'items' => $invoice->order->orderItems()->get(),
        ];

    }
}
