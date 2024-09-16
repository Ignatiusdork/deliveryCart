<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected static $nextOrderNumber = 1;

    protected $fillable = [
        'user_id','total', 'status', 'order_number', 'payment_method', 'year', 'month'
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer'
    ];

    // relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }
}
