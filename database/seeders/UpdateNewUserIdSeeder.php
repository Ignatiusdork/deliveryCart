<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class UpdateNewUserIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::chunk(1000, function ($orders) {
            foreach ($orders as $order) {
                // Update the user_id column with the value from temp_user_id
                $order->user_id = $order->temp_user_id;
                $order->save();

                // Optionally, you can log the updates
                Log::info("Updated user_id for order {$order->id} to {$order->user_id}");
            }
        });

        $this->command->info('New user_id column updated successfully.');
    }
}
