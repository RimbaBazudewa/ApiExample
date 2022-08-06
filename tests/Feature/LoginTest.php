<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use PhpParser\Node\Expr\FuncCall;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_register()
    {
        $response = $this->post('/api/register', [
            'name' => "Test User",
            "email" => "test@example.com",
            "password" => "password",
            "password_confirmation" => "password",
        ]);

        $response->assertJsonFragment([
            "name" => "Test User",
            "email" => "test@example.com",
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_user_login_logout()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login', [
            "email" =>  $user->email,
            "password" => "password",
        ], [
            'contentType' => 'application/json',
        ]);
        $response->assertJsonFragment([
            "name" => $user->name,
            "status" => true,
            "message"  => "success",
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('token')
            ->has('name')
            ->has('status')
            ->has("message"));

        $token = $response->json()['token'];
        $response = $this->withHeaders([
            "contentType" => 'application/json',
            "authorization" => $token,
        ])->post('/api/logout');
        $response->assertJsonFragment([
            "message" => "Berhasil Logout"
        ]);
    }
}
