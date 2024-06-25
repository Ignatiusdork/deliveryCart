<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartService
{
    protected $items = [];
    protected $sessionKey = 'cart';
}
