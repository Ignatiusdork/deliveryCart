<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/subscription', function (Request $request) {
    return $request->user();
});

Route::post('/stripe/webhook', function (Request $request) {
    // Handle webhook event for stripe
    Log::info('Received Stripe webhook event', $request->all());

    // Return a 200 OK response to Stripe
    return response()->json(['status' => 'success'], 200);
});
