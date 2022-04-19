<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Actions;

use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class LogoutTest extends FeatureTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Auth\Actions\Logout::asController
     * @covers \App\Auth\Actions\Logout::handle
     */
    public function testSuccess(): void
    {
        $password = 'asdfasdfasdf';
        $user = parent::createUser(password: $password);
        $login_uri = route(name: RouteEnum::AUTH_LOGIN->value);
        $logout_uri = route(name: RouteEnum::AUTH_LOGOUT->value);
        $request = [
            'email' => $user->email,
            'password' => $password,
        ];
        $result = $this->postJson($login_uri, $request);
        $result->assertStatus(200);
        $result = $this->getJson($logout_uri, $request);
        $result->assertStatus(200);
    }
}
