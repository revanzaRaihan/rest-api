<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcuctCollection;
use App\Models\Product;
use Illuminate\Http\Response;
// use GuzzleHttp\Psr7\Response;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->paginate(10);
        return response()->json(new ProcuctCollection($products), Response::HTTP_OK);
    }
}
