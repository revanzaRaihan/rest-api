<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop', 'price' => '15000000', 'description' => 'Laptop Gaming Terbaru', 'stock' => 10],
            ['name' => 'Monitor', 'price' => '2500000', 'description' => 'Monitor Gaming Terbaru', 'stock' => 5],
            ['name' => 'Keyboard', 'price' => '1500000', 'description' => 'Keyboard Gaming Terbaru', 'stock' => 8],
            ['name' => 'Mouse', 'price' => '500000', 'description' => 'Mouse Gaming Terbaru', 'stock' => 15],
            ['name' => 'Headset', 'price' => '750000', 'description' => 'Headset Gaming Terbaru', 'stock' => 12],
            ['name' => 'Motherboard', 'price' => '3000000', 'description' => 'Motherboard Terbaru', 'stock' => 6],
            ['name' => 'RAM 8GB', 'price' => '800000', 'description' => 'RAM DDR4 8GB', 'stock' => 20],
            ['name' => 'RAM 16GB', 'price' => '1500000', 'description' => 'RAM DDR4 16GB', 'stock' => 10],
            ['name' => 'SSD 256GB', 'price' => '1000000', 'description' => 'SSD 256GB Terbaru', 'stock' => 18],
            ['name' => 'SSD 512GB', 'price' => '1800000', 'description' => 'SSD 512GB Terbaru', 'stock' => 12],
            ['name' => 'HDD 1TB', 'price' => '900000', 'description' => 'HDD 1TB Terbaru', 'stock' => 10],
            ['name' => 'HDD 2TB', 'price' => '1500000', 'description' => 'HDD 2TB Terbaru', 'stock' => 8],
            ['name' => 'GPU RTX 3060', 'price' => '7000000', 'description' => 'GPU Gaming Terbaru', 'stock' => 5],
            ['name' => 'GPU RTX 3070', 'price' => '12000000', 'description' => 'GPU Gaming Terbaru', 'stock' => 3],
            ['name' => 'Power Supply 650W', 'price' => '800000', 'description' => 'PSU Terbaru', 'stock' => 10],
            ['name' => 'Power Supply 750W', 'price' => '1000000', 'description' => 'PSU Terbaru', 'stock' => 8],
            ['name' => 'Cooling Fan', 'price' => '150000', 'description' => 'Cooling Fan Terbaru', 'stock' => 20],
            ['name' => 'CPU Intel i5', 'price' => '3000000', 'description' => 'CPU Intel i5 Terbaru', 'stock' => 5],
            ['name' => 'CPU Intel i7', 'price' => '5000000', 'description' => 'CPU Intel i7 Terbaru', 'stock' => 4],
            ['name' => 'CPU AMD Ryzen 5', 'price' => '3500000', 'description' => 'CPU AMD Ryzen 5 Terbaru', 'stock' => 6],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, ['user_id' => 2])); // menambahkan user_id
        }
    }
}
