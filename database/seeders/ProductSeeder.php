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
        Product::create([
            'name' => 'Laptop',
            'price' => '150000',
            'description' => 'A high-performance laptop suitable for all your computing needs.',
            'stock' => 50,
        ]);
        Product::create([
            'name' => 'Smartphone',
            'price' => '80000',
            'description' => 'A sleek smartphone with the latest features and a stunning display.',
            'stock' => 100,
        ]);
        Product::create([
            'name' => 'Headphones',
            'price' => '20000',
            'description' => 'Noise-cancelling headphones for an immersive audio experience.',
            'stock' => 75,
        ]);
    }
}
