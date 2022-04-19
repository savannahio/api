<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Auth;

use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class LoginTest extends FeatureTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Auth\Actions\Login::asController
     * @covers \App\Auth\Actions\Login::handle
     */
    public function testSuccess(): void
    {
        $password = 'asdfasdfasdf';
        $user = parent::createUser(password: $password);
        $uri = route(name: RouteEnum::AUTH_LOGIN->value);
        $request = [
            'email' => $user->email,
            'password' => $password,
        ];
        $result = $this->postJson($uri, $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Auth\Actions\Login::handle
     * @covers \App\Auth\Actions\Login::rules
     */
    public function testUnauthorized(): void
    {
        $uri = route(name: RouteEnum::AUTH_LOGIN->value);
        $request = [
            'email' => 'asdfasdf@ddfa.com',
            'password' => 'asdfasdfasdfasdf',
        ];
        $result = $this->postJson($uri, $request);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Auth\Actions\Login::rules
     */
    public function testValidation(): void
    {
        $uri = route(name: RouteEnum::AUTH_LOGIN->value);
        $request = [];
        $result = $this->postJson($uri, $request);
        $response = $result->assertStatus(422);
        $result->assertJsonStructure(['message', 'errors' => ['email', 'password']], $response->json());
    }
}
