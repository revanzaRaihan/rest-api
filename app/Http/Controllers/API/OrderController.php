<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Customer lihat order sendiri
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return response()->json([
            'status' => true,
            'message' => 'Daftar pesanan saya',
            'data' => OrderResource::collection($orders),
        ], Response::HTTP_OK);
    }

    // Seller lihat semua order (dummy dulu)
    public function sellerOrders()
    {
        $orders = Order::all();
        return response()->json([
            'status' => true,
            'message' => 'Daftar pesanan customer',
            'data' => OrderResource::collection($orders),
        ], Response::HTTP_OK);
    }

    // Admin manage order
    public function update(OrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Order berhasil diupdate',
            'data' => new OrderResource($order),
        ], Response::HTTP_OK);
    }
}
    