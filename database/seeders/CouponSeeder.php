<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME20',
                'description' => '20% off for new customers',
                'discount_type' => 'percent',
                'discount_value' => 20,
                'min_purchase_amount' => 50,
                'max_usage' => 100,
                'times_used' => 15,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addMonths(3),
            ],
            [
                'code' => 'SUMMER15',
                'description' => '15% off summer sale',
                'discount_type' => 'percent',
                'discount_value' => 15,
                'min_purchase_amount' => 30,
                'max_usage' => 500,
                'times_used' => 145,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addMonths(2),
            ],
            [
                'code' => 'FLAT10',
                'description' => '$10 off any order',
                'discount_type' => 'fixed',
                'discount_value' => 10,
                'min_purchase_amount' => 25,
                'max_usage' => 1000,
                'times_used' => 342,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addMonths(6),
            ],
            [
                'code' => 'BOOKWORM30',
                'description' => '30% off for book club members',
                'discount_type' => 'percent',
                'discount_value' => 30,
                'min_purchase_amount' => 40,
                'max_usage' => 50,
                'times_used' => 28,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addMonths(4),
            ],
            [
                'code' => 'OLDCODE99',
                'description' => 'Expired coupon',
                'discount_type' => 'percent',
                'discount_value' => 10,
                'min_purchase_amount' => 20,
                'max_usage' => 100,
                'times_used' => 95,
                'is_active' => false,
                'start_date' => Carbon::now()->subMonths(6),
                'expires_at' => Carbon::now()->subDays(1),
            ],
            [
                'code' => 'VIP50',
                'description' => '50% off for VIP members',
                'discount_type' => 'percent',
                'discount_value' => 50,
                'min_purchase_amount' => 100,
                'max_usage' => 10,
                'times_used' => 3,
                'is_active' => true,
                'start_date' => Carbon::now(),
                'expires_at' => Carbon::now()->addMonth(),
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
