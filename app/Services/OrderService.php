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

        //generate PDF
        $pdf = Pdf::loadView('invoices.pdf', $data);

        // set PDF options
        $pdf->setPaper('A4');
        $pdf->setOrientation('portrait');

        // save the pdf to storage
        $filename = 'invoice_' . $invoice->invoice_number . '.pdf';
        Storage::put('public/invoices' . $filename, $pdf->output());

        // return the PDF as a downloadble file
        return response()->download(storage_path('app/public/invoices/' . $filename), $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
