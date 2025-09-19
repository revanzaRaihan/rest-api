<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 🔹 Kelola Semua User
    public function manageUsers()
    {
        $users = User::latest()->get();

        return response()->json([
            'status'  => true,
            'message' => 'Daftar semua user',
            'data'    => $users
        ]);
    }

    // 🔹 Kelola Seller
    public function manageSellers()
    {
        $sellers = User::where('role', 'seller')->latest()->get();

        return response()->json([
            'status'  => true,
            'message' => 'Daftar semua seller',
            'data'    => $sellers
        ]);
    }

    // 🔹 Laporan singkat
    public function reports()
    {
        $totalUsers    = User::count();
        $totalSellers  = User::where('role', 'seller')->count();
        $totalProducts = Product::count();
        $totalOrders   = Order::count();

        return response()->json([
            'status'  => true,
            'message' => 'Ringkasan laporan',
            'data'    => [
                'total_users'    => $totalUsers,
                'total_sellers'  => $totalSellers,
                'total_products' => $totalProducts,
                'total_orders'   => $totalOrders,
            ]
        ]);
    }

    // 🔹 Settings (dummy untuk sekarang)
    public function settings()
    {
        return response()->json([
            'status'  => true,
            'message' => 'Settings Admin',
            'data'    => [
                'maintenance_mode' => false,
                'version'          => '1.0.0',
            ]
        ]);
    }
}
