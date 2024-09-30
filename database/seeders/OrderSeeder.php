<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::chunk(100, function ($orders) {
            foreach ($orders as $order) {
                $order->update([
                    'month' => $order->created_at ? $order->created_at->format('m') : Carbon::now()->format('m'),
                ]);
            }
        });
    }
}
