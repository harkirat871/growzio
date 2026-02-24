<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General',
                'description' => 'Default category for products when specified category does not exist',
            ],
            [
                'name' => 'Gaming',
                'description' => 'Video games, gaming accessories, and gaming equipment',
            ],
            [
                'name' => 'Daily Use',
                'description' => 'Everyday items and household essentials',
            ],
            [
                'name' => 'Cooking',
                'description' => 'Kitchen appliances, cookware, and cooking accessories',
            ],
            [
                'name' => 'Electronics',
                'description' => 'Computers, phones, tablets, and electronic devices',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Clothing, shoes, and fashion accessories',
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment, fitness gear, and outdoor activities',
            ],
            [
                'name' => 'Books',
                'description' => 'Books, magazines, and educational materials',
            ],
            [
                'name' => 'Others',
                'description' => 'Miscellaneous items and other categories',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
