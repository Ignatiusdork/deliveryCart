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

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->$paymentService = $paymentService;
    }

    public function stripe($total)
    {
        return view('stripe.show', compact("total"));
    }

    public function stripePost(Request $request, $total)
    {
        return $this->paymentService->processStripePayment($total, $request);
    }
}
