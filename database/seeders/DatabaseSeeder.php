<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Product::query()->firstOrCreate([
            'name' => 'Sample Phone',
        ], [
            'description' => 'A nice smartphone for testing',
            'price' => 599.99,
            'stock' => 20,
            'image_path' => null,
        ]);
        Product::query()->firstOrCreate([
            'name' => 'Sample Laptop',
        ], [
            'description' => 'A powerful laptop for testing',
            'price' => 1299.00,
            'stock' => 10,
            'image_path' => null,
        ]);
        Product::query()->firstOrCreate([
            'name' => 'Sample Headphones',
        ], [
            'description' => 'Wireless over-ear headphones',
            'price' => 199.50,
            'stock' => 30,
            'image_path' => null,
        ]);

        $this->call([CategorySeeder::class, ProductSeeder::class]);
    }
}
