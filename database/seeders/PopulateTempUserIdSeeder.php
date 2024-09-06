<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PopulateTempUserIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // protected $signature = 'update:new-user-id';
    // protected $description = 'Update new user_id column with values from temp_user_id';
    public function run(): void
    {

        Order::chunk(1000, function ($orders) {
            foreach ($orders as $order) {
                foreach ($orders as $order) {
                    // Logic to find the correct user ID for each order
                    // For example, assuming you know which field contains the customer email:
                    $user = User::where('email', $order->email)->first();

                    if ($user) {
                        $order->temp_user_id = $user->id;
                        $order->save();
                    } else {
                        // Log or handle cases where no matching user is found
                        Log::warning("No matching user found for order {$order->id}");
                    }
                }
            }
        });

        $this->command->info('Temp user IDs populated successfully.');
    }
}
