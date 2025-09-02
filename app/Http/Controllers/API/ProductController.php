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
    public function index(){
        $products = Product::latest()->paginate(10);
        return response()->json(new ProcuctCollection($products), Response::HTTP_OK);
    }

    public function store(ProductRequest $request) {
        $productData = Product::create($request->validated());
        return response()->json([
            'status'     => 'true',
            'message'    => 'produk berhasil ditambahkan',
            'data'       => new ProductResource($productData)
        ], Response::HTTP_CREATED);
    }
    public function show() {

    }
    public function update() {

    }
    public function destroy() {

    }
}
