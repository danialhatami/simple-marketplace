<?php

namespace Danial\SimpleMarketplace\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'delivery_price' => $this->delivery_price,
            'price' => $this->price,
            'images' => ProductImageResource::collection($this->images)
        ];
    }
}
