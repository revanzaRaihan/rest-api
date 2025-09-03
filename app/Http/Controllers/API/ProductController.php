<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProcuctCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Response;
// use GuzzleHttp\Psr7\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return response()->json(new ProcuctCollection($products), Response::HTTP_OK);
    }

    public function store(ProductRequest $request)
    {
        $productData = Product::create($request->validated());
        return response()->json([
            'status' => 'true',
            'message' => 'Produk berhasil ditambahkan!',
            'data' => new ProductResource($productData)
        ], Response::HTTP_CREATED);
    }
    public function show($id)
    {
        $productID = Product::FindOrFail($id);
        return response()->json([
            'status' => 'true',
            'message' => 'Detail produk!',
            'data' => new ProductResource($productID)
        ], Response::HTTP_OK);
    }
    public function update(ProductRequest $request, $id)
    {
        $productUpdate = Product::findOrFail($id);
        $productUpdate->update($request->validated());

        return response()->json([
            'status' => 'true',
            'message' => 'Data produk berhasil diupdate!',
            'data' => new ProductResource($productUpdate)
        ], Response::HTTP_OK);
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => 'true',
            'message' => 'Data produk berhasil dihapus!',
            'data' => new ProductResource($product)
        ], Response::HTTP_OK);
    }
}
