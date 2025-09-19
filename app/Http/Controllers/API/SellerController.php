<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    // 🔹 Dashboard Seller (ringkasan)
    public function dashboard()
    {
        $sellerId = Auth::id();

        $totalProducts = Product::where('user_id', $sellerId)->count();
        $totalOrders   = Order::where('seller_id', $sellerId)->count();
        $pendingOrders = Order::where('seller_id', $sellerId)->where('status', 'pending')->count();

        return response()->json([
            'status' => true,
            'message' => 'Seller Dashboard',
            'data' => [
                'total_products' => $totalProducts,
                'total_orders'   => $totalOrders,
                'pending_orders' => $pendingOrders,
            ]
        ]);
    }

    // 🔹 List Produk Seller
    public function products()
    {
        $sellerId = Auth::id();
        $products = Product::where('user_id', $sellerId)->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Produk milik seller',
            'data' => $products
        ]);
    }

    // 🔹 Orders untuk Seller
    public function orders()
    {
        $sellerId = Auth::id();
        $orders = Order::where('seller_id', $sellerId)->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Order terkait seller',
            'data' => $orders
        ]);
    }
}
