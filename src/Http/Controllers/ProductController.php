<?php

namespace Danial\SimpleMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Danial\SimpleMarketplace\Http\Requests\CreateProductRequest;
use Danial\SimpleMarketplace\Http\Requests\SearchProductRequest;
use Danial\SimpleMarketplace\Models\Product;
use Danial\SimpleMarketplace\Http\Resources\ProductResource;
use Danial\SimpleMarketplace\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(SearchProductRequest $request): AnonymousResourceCollection
    {
        $products = $this->productService->searchProducts($request->validated());
        return ProductResource::collection($products);
    }

    public function create(CreateProductRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $product = $this->productService->createProduct(
            title: $request->title,
            price: $request->price,
            deliveryPrice: $request->delivery_price,
            user: $user,
            images: $request->file('images')
        );
        return response()->json([
            'message' => 'Product Created Successfully',
            'data' => ProductResource::make($product)
        ]);
    }

    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
    }

    public function delete(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json([
            'message' => 'Product Deleted Successfully',
        ]);
    }
}
