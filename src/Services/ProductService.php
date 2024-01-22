<?php

namespace Danial\SimpleMarketplace\Services;

use App\Models\User;
use Danial\SimpleMarketplace\Exceptions\DatabaseException;
use Danial\SimpleMarketplace\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(
        private readonly ProductImageService $productImageService
    ) {
    }

    public function createProduct(
        string $title,
        int $price,
        int $deliveryPrice,
        User $user,
        array $images
    ): Product {
        try {
            return DB::transaction(function () use ($title, $price, $deliveryPrice, $user, $images) {
                $product = Product::create([
                    'title' => $title,
                    'price' => $price,
                    'delivery_price' => $deliveryPrice,
                    'user_id' => $user->id
                ]);
                $this->productImageService->store(
                    $images,
                    $product
                );
                return $product;
            });
        } catch (\Throwable $e) {
            throw new DatabaseException('There was an error in creating.');
        }
        Cache::forget('products_search_*');
    }

    public function getUserProducts(User $user): LengthAwarePaginator
    {
        return $this->searchProducts(['user_id' => $user->id]);
    }

    public function searchProducts(array $params): LengthAwarePaginator
    {
        $cacheKey = 'products_search_' . md5(serialize($params));

        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($params) {
            return Product::query()
                ->when($params['query'] ?? null, function ($query, $text) {
                    return $query->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$text]);
                })
                ->when($params['max_price'] ?? null, function ($query, $maxPrice) {
                    return $query->whereRaw("price + delivery_price <= ?", [$maxPrice]);
                })
                ->when($params['user_id'] ?? null, function ($query, $userId) {
                    return $query->where('user_id', $userId);
                })
                ->orderByRaw("price + delivery_price " . ($params['sort_by_price'] ?? 'asc'))
                ->paginate(config('marketplace.products_per_page'));
        });
    }
}
