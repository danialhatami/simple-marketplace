<?php

namespace Danial\SimpleMarketplace\Tests\Feature;

use App\Models\User;
use Danial\SimpleMarketplace\Events\OrderCreated;
use Danial\SimpleMarketplace\Models\Order;
use Danial\SimpleMarketplace\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order()
    {
        Notification::fake();
        Event::fake();
        $user = User::factory()->create();
        $product = Product::factory()->create();
        Sanctum::actingAs($user);

        $requestData = [
            'products' => [
                [
                    'id' => $product->id,
                    'quantity' => 2,
                    'delivery' => true,
                ],
            ],
        ];

        $response = $this->postJson(route('api.v1.order.create.post'), $requestData);
        Event::assertDispatched(OrderCreated::class);

        $response->assertStatus(Response::HTTP_CREATED)->assertJsonStructure([
            'data' => ['id', 'tracking_code', 'details']
        ]);
    }
}
