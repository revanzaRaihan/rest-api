<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'buyer'      => $this->user?->name,          // pembeli
            'seller'     => $this->seller?->name,        // penjual
            'product'    => [
                'id'    => $this->product?->id,
                'name'  => $this->product?->name,
                'price' => $this->product?->price,
            ],
            'quantity'   => $this->quantity,
            'total'      => $this->total,
            'status'     => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
