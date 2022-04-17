<?php

namespace Tests\Feature\Actions\Auth;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\Login::handle
     * @covers \App\Actions\Auth\Login::asController
     */
    public function testSuccess(): void
    {
        $password = 'asdfasdfasdf';
        $user = parent::createUser(password: $password);
        $request = [
            'email' => $user->email,
            'password' => $password,
        ];
        $result = $this->postJson(route(RouteEnum::AUTH_LOGIN->value), $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Auth\Login::rules
     */
    public function testUnauthorized(): void
    {
        $request = [
            'email' => 'asdfasdf@ddfa.com',
            'password' => 'asdfasdfasdfasdf',
        ];
        $result = $this->postJson(route(RouteEnum::AUTH_LOGIN->value), $request);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\Auth\Login::rules
     */
    public function testValidation(): void
    {
        $request = [];
        $result = $this->postJson(route(RouteEnum::AUTH_LOGIN->value), $request);
        $response = $result->assertStatus(422);
        $result->assertJsonStructure(['message', 'errors' => ['email', 'password']], $response->json());
    }
}