<?php

namespace Danial\SimpleMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Danial\SimpleMarketplace\Http\Requests\CreateOrderRequest;
use Danial\SimpleMarketplace\Http\Resources\OrderResource;
use Danial\SimpleMarketplace\Models\Order;
use Danial\SimpleMarketplace\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection($this->orderService->getAllOrders());
    }

    public function create(CreateOrderRequest $request): OrderResource
    {
        /** @var User $user */
        $user = Auth::user();
        $order = $this->orderService->createOrder($user, $request->validated()['products']);
        return OrderResource::make($order);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json($order);
    }
}
