<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Faker\Factory::create();

        $faker = \Faker\Factory::create();

        $productNames = [
            'Premium Wireless Headphones',
            'Smart LED TV 55"',
            'Gaming Laptop Pro',
            'Wireless Bluetooth Speaker',
            '4K Action Camera',
            'Smart Fitness Watch',
            'Portable Power Bank',
            'Wireless Gaming Mouse',
            'Mechanical Keyboard RGB',
            'USB-C Fast Charger',
            'Bluetooth Earbuds Pro',
            'Smart Home Hub',
            'Portable SSD 1TB',
            'Wireless Charging Pad',
            'Gaming Headset 7.1',
            'Smartphone Gimbal',
            'Laptop Cooling Pad',
            'Wireless Presenter',
            'USB Microphone Pro',
            'Cable Management Kit'
        ];

        $productImages = [
            'headphone.webp',
            'laptop.webp', 
            'keyboard.webp',
            'phone.webp',
            'ps5.jpg'
        ];

        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => $productNames[$i] ?? $faker->words(3, true),
                'description' => $faker->paragraphs(2, true),
                'price' => $faker->randomFloat(2, 100, 5000),
                'stock' => $faker->numberBetween(1, 50),
                'image_path' => 'products/' . $productImages[array_rand($productImages)],
                'user_id' => 1, // Assign to first user (admin)
            ]);
        }
    }
}


