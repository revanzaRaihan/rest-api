<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // 🔹 siapa pembeli
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 🔹 siapa penjual (seller)
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');

            // 🔹 produk yang dibeli
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // 🔹 jumlah barang
            $table->integer('quantity');

            // 🔹 total harga
            $table->decimal('total', 12, 2);

            // 🔹 status pesanan
            $table->string('status')->default('pending'); // pending, paid, shipped, completed

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
