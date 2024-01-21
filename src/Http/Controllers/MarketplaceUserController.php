<?php

namespace Danial\SimpleMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Danial\SimpleMarketplace\Http\Resources\OrderResource;
use Danial\SimpleMarketplace\Http\Resources\ProductResource;
use Danial\SimpleMarketplace\Services\OrderService;
use Danial\SimpleMarketplace\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class MarketplaceUserController extends Controller
{

    public function __construct(
        private readonly ProductService $productService,
        private readonly OrderService $orderService
    ) {
    }

    public function userProducts(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();
        $userProducts = $this->productService->getUserProducts($user);
        return ProductResource::collection($userProducts);
    }

    public function userOrders(): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = Auth::user();
        $userOrders = $this->orderService->getUserOrders($user);
        return OrderResource::collection($userOrders);
    }

}
