<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'order_id', 'amount', 'status'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
