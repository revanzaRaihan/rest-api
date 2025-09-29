<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',     // pembeli
        'seller_id',   // penjual
        'product_id',  // produk yang dibeli
        'quantity',    // jumlah item
        'total',       // total harga
        'status',      // status order
    ];

    // 🔹 Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Relasi ke seller (juga user, tapi role penjual)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // 🔹 Relasi ke produk
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
