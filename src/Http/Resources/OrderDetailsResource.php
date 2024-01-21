<?php

namespace Danial\SimpleMarketplace\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_price' => $this->product_price,
            'quantity' => $this->quantity,
            'product_delivery_price' => $this->product_delivery_price,
        ];
    }
}
