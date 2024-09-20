<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderService
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function placeOrder(array $items)
    {
       // Fetch cart items from CartService and the totalprice
       $items = $this->cartService->view();
       $totalPrice = $this->cartService->getTotal();

       // handle if cart is empty
       if (empty($items)) {
        return null;
       }

       //generate order number
       $orderNumber = $this->getNextOrderNumber();

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total' => $totalPrice,
            //'order_number' => $orderNumber
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

        $this->createInvoice($order);

        return $order;

    }
    // get the genrated order number
    public function getNextOrderNumber() {

        $latestOrder = Order::orderBy('created_at', 'desc')->first();
        $currentYear = date('Y');
        $currentMonth = date('m');

        if (!$latestOrder || $latestOrder->year != $currentYear || $latestOrder->month != $currentMonth) {
            return sprintf('%04d%s001', $currentYear, $currentMonth);
        }

        $lastNumber = intval($latestOrder->order_number);
        $newNumber = $lastNumber + 1;

        return sprintf('%06d', $newNumber);
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

    private function createInvoice(Order $order) {

        Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'total' => $order->total,
            'status' => $order->status,
        ]);
    }

    private function generateInvoiceNumber() {
        return 'INV-' . now()->format('YmdHis') . '-' . rand(10000, 99999);
    }

    public function downloadInvoice($invoiceId) {

        $invoice = Invoice::findOrFail($invoiceId);

        //prepare invoice data
        $data = [
            'invoice' => $invoice,
            'order' => $invoice->order,
            'items' => $invoice->order->orderItems()->get(),
        ];

        $total = $data['items']->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $data['total'] = $total;

        //generate PDF
        $pdf = Pdf::loadView('invoices.pdf', $data);

        // save the pdf to storage
        return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
    }
}
