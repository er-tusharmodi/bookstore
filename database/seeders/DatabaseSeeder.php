<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeders in order
        $this->call(RoleSeeder::class);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@booknest.test',
        ]);
        $admin->assignRole('super_admin');

        // Create test customer
        $customer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@booknest.test',
        ]);
        $customer->assignRole('customer');

        // Seed core data
        $this->call(AuthorSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(FormatSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(HomepageSettingSeeder::class);
        $this->call(SiteSettingSeeder::class);
    }
}
