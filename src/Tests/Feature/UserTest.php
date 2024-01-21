<?php

namespace Danial\SimpleMarketplace\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_user_register()
    {
        $response = $this->postJson(
            route('api.v1.register'),
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $this->faker->password,
            ]
        );

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'accessToken'
            ]);
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = $this->faker->password),
        ]);

        $response = $this->postJson(
            route('api.v1.login'),
            [
                'email' => $user->email,
                'password' => $password,
            ]
        );
        $response->assertStatus(200)->assertJsonStructure(['accessToken']);
    }

    public function test_user_profile()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson(
            route('api.v1.user_profile.get')
        );
        $response->assertStatus(200)->assertJson([
            'email' => $user->email,
        ]);
    }

    public function test__unauthorized_user()
    {
        $response = $this->getJson(
            route('api.v1.user_profile.get')
        );

        $response->assertStatus(401);
    }
}
