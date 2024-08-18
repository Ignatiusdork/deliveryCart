<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    /**
    * success response method.
    *
    * @return \Illuminate\Http\Response
    */

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
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
