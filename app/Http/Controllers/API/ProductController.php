<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProcuctCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->latest()->paginate(10);

        return response()->json(
            new ProductCollection($products),
            Response::HTTP_OK
        );
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create([
            'user_id'     => Auth::id(),
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'stock'       => $validated['stock'],
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Product berhasil ditambahkan',
            'data'    => new ProductResource($product),
        ], Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $product = Product::with('user')->findOrFail($id);

        return response()->json([
            'status'  => true,
            'message' => 'Detail Product',
            'data'    => new ProductResource($product),
        ], Response::HTTP_OK);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $user    = Auth::user();

        // 🔹 Seller hanya bisa update produk miliknya
        if ($user->role === 'seller' && $product->user_id !== $user->id) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized: kamu bukan pemilik produk ini',
            ], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validated();
        $product->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Product berhasil di update',
            'data'    => new ProductResource($product),
        ], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $user    = Auth::user();

        // 🔹 Seller hanya bisa hapus produk miliknya
        if ($user->role === 'seller' && $product->user_id !== $user->id) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized: kamu bukan pemilik produk ini',
            ], Response::HTTP_FORBIDDEN);
        }

        // 🔹 Admin bisa hapus produk siapa pun
        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product berhasil dihapus',
        ], Response::HTTP_OK);
    }
}
