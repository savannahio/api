<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Auth;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResetPasswordTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::AUTH_RESET_PASSWORD->value);
        $result = $this->postJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\Auth\ResetPassword::asController
     */
    public function testResetPasswordApi(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::AUTH_RESET_PASSWORD->value);
        $this->actingAs($user);
        $request = [
            'new_password' => 'asdfasfasdfasfd',
            'new_password_confirmation' => 'asdfasfasdfasfd',
        ];
        $result = $this->postJson($uri, $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Auth\ResetPassword::asController
     * @covers \App\Actions\Auth\ResetPassword::rules
     */
    public function testResetPasswordApiPasswordMismatch(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::AUTH_RESET_PASSWORD->value);
        $this->actingAs($user);
        $request = [
            'new_password' => 'asdfasfasdfasfd',
            'new_password_confirmation' => 'asdf',
        ];
        $result = $this->postJson($uri, $request);
        $result->assertStatus(422);
    }

    /**
     * @covers \App\Actions\Auth\ResetPassword::asController
     * @covers \App\Actions\Auth\ResetPassword::rules
     */
    public function testResetPasswordApiMissingConfirmation(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::AUTH_RESET_PASSWORD->value);
        $this->actingAs($user);
        $request = [
            'new_password' => 'asdfasfasdfasfd',
        ];
        $result = $this->postJson($uri, $request);
        $result->assertStatus(422);
    }
}
