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

        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => $faker->words(3, true),
                'description' => $faker->paragraphs(2, true),
                'price' => $faker->randomFloat(2, 100, 5000),
                'stock' => $faker->numberBetween(1, 50),
                'image_path' => null,
            ]);
        }
    }
}


