<?php

namespace Danial\SimpleMarketplace\Tests\Feature;

use App\Models\User;
use Danial\SimpleMarketplace\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_create_product()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $image = UploadedFile::fake()->image('product.jpg');
        $response = $this->postJson(
            route('api.v1.product.create.post'),
            [
                'title' => $this->faker->name,
                'price' => $this->faker->numberBetween(1500, 6000),
                'delivery_price' => $this->faker->numberBetween(0, 200),
                'images' => [$image]
            ]
        );
        $response->assertStatus(200)->assertJson(['message' => 'Product Created Successfully']);
    }

    public function test_product_index()
    {
        $this->test_create_product();

        $response = $this->getJson(route('api.v1.product.index.get'));
        $response->assertStatus(200)->assertJsonStructure(
            [
                'data' =>
                    [
                        '*' => ['id', 'title', 'price', 'delivery_price', 'images']
                    ],
            ]
        );
    }

    public function test_product_create_failed()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('api.v1.product.create.post'), [
            'title' => '',
        ]);

        $response->assertStatus(422);
    }

    public function test_delete_product_success()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('api.v1.product.destroy.delete', $product->id));

        $response->assertStatus(200)->assertJson(['message' => 'Product Deleted Successfully']);
    }

    public function test_user_cannot_delete_product()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $product = Product::factory()->create(['user_id' => $anotherUser->id]);
        Sanctum::actingAs($user);
        $response = $this->deleteJson(route('api.v1.product.destroy.delete', $product->id));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
