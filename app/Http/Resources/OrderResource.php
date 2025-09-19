<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'user'      => $this->user->name,
            'total'     => $this->total,
            'status'    => $this->status,
            'created_at'=> $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
