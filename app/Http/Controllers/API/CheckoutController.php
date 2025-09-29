<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    public function process(CheckoutRequest $request)
{
    $userId = Auth::id();

    // 🔹 Simpan histori checkout utama
    $checkout = Checkout::create([
        'user_id'      => $userId,
        'total_amount' => $request->total_amount,
        'status'       => 'pending',
        'items'        => $request->items,
    ]);

    // 🔹 Loop item -> buat order per seller
    foreach ($request->items as $item) {
        $product = Product::find($item['product_id']);
        if (!$product) continue;

        Order::create([
            'user_id'    => $userId,             // pembeli
            'seller_id'  => $product->user_id,   // penjual
            'product_id' => $product->id,        // simpan produk
            'quantity'   => $item['quantity'],   // simpan jumlah
            'total'      => $product->price * $item['quantity'],
            'status'     => 'pending',
        ]);
    }

    // 🔹 Clear cart setelah checkout
    \App\Models\Cart::where('user_id', $userId)->delete();

    return response()->json([
        'status'  => true,
        'message' => 'Checkout berhasil dibuat & pesanan masuk ke seller',
        'data'    => new CheckoutResource($checkout),
    ], Response::HTTP_CREATED);
}


    public function myCheckouts()
    {
        $checkouts = Checkout::where('user_id', Auth::id())->latest()->get();
        return CheckoutResource::collection($checkouts);
    }
}
