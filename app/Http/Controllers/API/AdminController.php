<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // 🔹 Ganti Role User
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,seller,viewer',
        ]);

        $user->role = $request->role;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Role user berhasil diubah',
            'data'    => $user
        ]);
    }

    // 🔹 Hapus User
    public function destroyUser(User $user)
    {
        if (Auth::id() === $user->id) {
    return response()->json([
        'status'  => false,
        'message' => 'Tidak bisa menghapus akun sendiri',
    ], 403);
}

        $user->delete();

        return response()->json([
            'status'  => true,
            'message' => 'User berhasil dihapus',
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
