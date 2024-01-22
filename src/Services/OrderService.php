<?php

namespace Danial\SimpleMarketplace\Services;

use App\Models\User;
use Danial\SimpleMarketplace\Events\OrderCreated;
use Danial\SimpleMarketplace\Models\Order;
use Danial\SimpleMarketplace\Models\Product;
use Illuminate\Support\Collection;

class OrderService
{
    public function createOrder(User $user, array $products)
    {
        $totalPrice = 0;
        $order = Order::create(['user_id' => $user->id]);
        foreach ($products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $deliveryPrice = $productData['delivery'] ? $product->delivery_price : 0;
            $order->orderDetails()->create([
                'product_id' => $product->id,
                'product_price' => $product->price,
                'product_delivery_price' => $deliveryPrice,
                'quantity' => $productData['quantity']
            ]);

            $totalPrice += $product->price * $productData['quantity'];
            $totalPrice += $deliveryPrice;
        }
        $order->update(['total_price' => $totalPrice]);
        event(new OrderCreated($order));
        return $order;
    }

    public function getUserOrders(User $user): Collection
    {
        return Order::where('user_id', $user->id)->get();
    }

    public function getAllOrders(): Collection
    {
        return Order::all();
    }

}
