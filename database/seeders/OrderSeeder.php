<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Store;
use App\Models\Book;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Get stores and books
        $stores = Store::all();
        $books = Book::all();

        // Create 20 orders from customers
        $customers = User::whereHas('roles', function ($q) {
            $q->where('name', 'customer');
        })->get();

        if ($customers->isEmpty()) {
            // Create some customers if they don't exist
            for ($i = 1; $i <= 10; $i++) {
                $customer = User::create([
                    'name' => "Customer $i",
                    'email' => "customer$i@booknest.test",
                    'password' => bcrypt('password'),
                ]);
                $customer->assignRole('customer');
                $customers->push($customer);
            }
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        for ($i = 0; $i < 20; $i++) {
            $customer = $customers->random();
            $store = $stores->random();
            $orderDate = Carbon::now()->subDays(rand(0, 60));

            // Generate order total and items
            $subtotal = 0;
            $items = [];
            $numItems = rand(1, 5);

            for ($j = 0; $j < $numItems; $j++) {
                $book = $books->random();
                $quantity = rand(1, 3);
                $price = $book->price + rand(-5, 10);
                $itemTotal = $quantity * $price;
                $subtotal += $itemTotal;

                $items[] = [
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $itemTotal,
                ];
            }

            // Calculate taxes and shipping
            $tax = round($subtotal * 0.1, 2);
            $shipping = rand(0, 1) ? 0 : 5; // 50% free shipping
            $total = $subtotal + $tax + $shipping;

            $order = Order::create([
                'order_number' => 'ORD-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'user_id' => $customer->id,
                'store_id' => $store->id,
                'placed_at' => $orderDate,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'status' => $statuses[array_rand($statuses)],
                'notes' => rand(0, 1) ? "Special delivery request" : null,
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item['book_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'line_total' => $item['total'],
                ]);
            }
        }
    }
}
