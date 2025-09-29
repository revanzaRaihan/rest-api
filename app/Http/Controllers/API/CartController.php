<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(CartRequest $request)
    {
        $cart = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        $cart->quantity = ($cart->quantity ?? 0) + (int) $request->quantity;
        $cart->save();

        return response()->json([
            'status' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'data' => new CartResource($cart),
        ], Response::HTTP_CREATED);
    }

    public function show()
    {
        $carts = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Keranjang belanja',
            'data' => CartResource::collection($carts),
        ], Response::HTTP_OK);
    }

    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();

        return response()->json([
            'status' => true,
            'message' => 'Item berhasil dihapus dari keranjang',
        ], Response::HTTP_OK);
    }

    public function clear()
    {
        $userId = Auth::id();

        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Keranjang berhasil dikosongkan',
        ], Response::HTTP_OK);
    }
}
