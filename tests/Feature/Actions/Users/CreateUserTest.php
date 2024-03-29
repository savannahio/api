<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateUserTest extends FeatureTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\CreateUser::asController
     * @covers \App\Actions\Users\CreateUser::rules
     */
    public function testSuccessfulApiCall(): void
    {
        $request = [
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'test@test.com',
            'password' => 'testasdf',
            'password_confirmation' => 'testasdf',
        ];
        $uri = route(name: RouteEnum::USERS_CREATE->value);
        $result = $this->postJson($uri, $request);
        $result->assertStatus(201);
        $result->assertJsonStructure([
            'id', 'first_name', 'last_name', 'email',
        ]);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::asController
     * @covers \App\Actions\Users\CreateUser::rules
     */
    public function testPasswordsDoNotMatch(): void
    {
        $request = [
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'test@test.com',
            'password' => 'testasdf',
            'password_confirmation' => 'asdfasdf',
        ];
        $uri = route(name: RouteEnum::USERS_CREATE->value);
        $result = $this->postJson($uri, $request);
        $result->assertStatus(422);
        $result->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::asController
     * @covers \App\Actions\Users\CreateUser::rules
     */
    public function testRequiredFields(): void
    {
        $request = [];
        $uri = route(name: RouteEnum::USERS_CREATE->value);
        $result = $this->postJson($uri, $request);
        $result->assertStatus(422);
        $result->assertJsonStructure(
            ['message',
                'errors' => ['email', 'first_name', 'last_name', 'password'],
            ]
        );
    }
}
