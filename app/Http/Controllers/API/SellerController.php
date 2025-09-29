<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * 🔹 Dashboard Seller (ringkasan)
     */
    public function dashboard()
    {
        $sellerId = Auth::id();

        $totalProducts = Product::where('user_id', $sellerId)->count();
        $totalOrders   = Order::where('seller_id', $sellerId)->count();
        $pendingOrders = Order::where('seller_id', $sellerId)
            ->where('status', 'pending')
            ->count();

        return response()->json([
            'status'  => true,
            'message' => 'Seller Dashboard',
            'data'    => [
                'total_products' => $totalProducts,
                'total_orders'   => $totalOrders,
                'pending_orders' => $pendingOrders,
            ]
        ]);
    }

    /**
     * 🔹 List Produk Seller
     */
    public function products()
    {
        $sellerId = Auth::id();
        $products = Product::where('user_id', $sellerId)
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Produk milik seller',
            'data'    => $products
        ]);
    }

    /**
     * 🔹 Orders untuk Seller
     */
    public function orders()
    {
        $sellerId = Auth::id();

        $orders = Order::with(['user', 'product'])
            ->where('seller_id', $sellerId)
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Order terkait seller',
            'data'    => OrderResource::collection($orders)
        ]);
    }

    /**
     * 🔹 Tandai Order Selesai
     */
    public function completeOrder($id)
    {
        $sellerId = Auth::id();

        $order = Order::where('id', $id)
            ->where('seller_id', $sellerId)
            ->firstOrFail();

        $order->status = 'completed';
        $order->save();

        return response()->json([
            'status'  => true,
            'message' => 'Order berhasil ditandai selesai',
            'data'    => new OrderResource($order)
        ]);
    }
}
