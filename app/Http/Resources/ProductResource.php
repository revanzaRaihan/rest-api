<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'created_at'  => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'  => $this->updated_at?->format('Y-m-d H:i:s'),
            'image'       => $this->image,
            // Tambahkan informasi user/kreator
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id'   => $this->user->id,
                    'name' => $this->user->name,
                    'role' => $this->user->role,
                ];
            }),
        ];
    }
}
