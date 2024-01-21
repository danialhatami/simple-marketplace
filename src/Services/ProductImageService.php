<?php

namespace Danial\SimpleMarketplace\Services;

use Danial\SimpleMarketplace\Models\Product;
use Danial\SimpleMarketplace\Models\ProductImage;

class ProductImageService
{
    public function store(array $images, Product $product): void
    {
        foreach ($images as $image) {
            $path = $image->store('product_images', 'public');
            $this->saveImagePath($path, $product);
        }
    }

    protected function saveImagePath($path, Product $product): void
    {
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $path
        ]);
    }
}
