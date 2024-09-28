<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Product::factory()->count(30)->create();

        Order::all()->each(function ($order) {
            $parts = explode('-', $order->created_at->format('Y-m'));
            $order->update([
                'year' => intval($parts[0]),
                'month' => intval($parts[1]),
                'order_number' => sprintf('%04d%s001', $parts[0], $parts[1]),
            ]);
        });

        $this->call([
            PopulateTempUserIdSeeder::class,
            UpdateNewUserIdSeeder::class,
        ]);
    }
}
