<?php

namespace Danial\SimpleMarketplace\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_price' => $this->totalPrice,
            'tracking_code' => 'TRC-' . now()->year . $this->id,
            'details' => OrderDetailsResource::collection($this->orderDetails),
        ];
    }
}
