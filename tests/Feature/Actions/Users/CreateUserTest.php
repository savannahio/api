<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateUserTest extends TestCase
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

        $result = $this->postJson(route(RouteEnum::USERS_CREATE->value), $request);
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

        $result = $this->postJson(route(RouteEnum::USERS_CREATE->value), $request);
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

        $result = $this->postJson(route(RouteEnum::USERS_CREATE->value), $request);
        $result->assertStatus(422);
        $result->assertJsonStructure(
            ['message',
                'errors' => ['email', 'first_name', 'last_name', 'password'],
            ]
        );
    }
}
