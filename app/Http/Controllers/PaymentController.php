<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */

    protected $cartService;
    protected $paymentService;

    public function __construct(CartService $cartService, PaymentService $paymentService)
    {
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
    }

    public function stripe($total)
    {
        return view('stripe.show', compact("total"));
    }

    public function stripePost(Request $request)

    {
        $total = $this->cartService->getTotal();
        $token = $request->input('stripeToken');

        return $this->paymentService->processStripePayment($total, $token);
    }

}
