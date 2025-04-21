<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserActivity extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_auth_user(): void
    {
        Passport::actingAs(
            User::where('id', 1)->first(),
            ['*']
        );

        $response = $this->getJson('api/user');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_user_store(): void
    {
        Passport::actingAs(
            User::where('id', 1)->first(),
            ['*']
        );

        $credentials = [
            'name' => 'Md Shohag Hossain',
            'email' => 'shohag@atilimited.net',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];

        $response = $this->postJson('api/user', $credentials);

        $response->assertStatus(201);
    }

    /**
     * A basic feature test example.
     */
    public function test_user_update(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user, ['*']);

        $credentials = [
            'name' => 'Md. Shohag Hossain',
            'email' => 'shohagi@atilimited.net',
            'password' => '12345678'
        ];
        $response = $this->patchJson("api/user/{$user->id}", $credentials);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function test_user_delete(): void
    {
        Passport::actingAs(
            User::where('id', 1)->first(),
            ['*']
        );

        $user_id = User::where('active_status', 1)->pluck('id')->first();

        $response = $this->deleteJson("api/user/{$user_id}");
        $response->assertStatus(200);
    }
}
