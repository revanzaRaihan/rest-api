<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    public function process(CheckoutRequest $request)
    {
        $checkout = Checkout::create([
            'user_id' => Auth::id(),
            'total_amount' => $request->total_amount,
            'status' => 'pending',
            'items' => $request->items,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Checkout berhasil dibuat',
            'data' => new CheckoutResource($checkout),
        ], Response::HTTP_CREATED);
    }

    public function myCheckouts()
    {
        $checkouts = Checkout::where('user_id', Auth::id())->latest()->get();

        return CheckoutResource::collection($checkouts);
    }
}
