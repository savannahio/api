<?php

namespace Tests\Feature\Actions\Auth;

use App\Actions\Users\CreateUser;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetAuthUserTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\GetAuthUser::asController
     */
    public function testSuccessfulGet(): void
    {
        $user = CreateUser::make()->handle('first', 'last', 'test@test.com', 'testasdf');
        $this->actingAs($user);
        $result = $this->getJson(route(RouteEnum::USERS_ME->value));
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'first_name', 'last_name', 'email', 'meta' => ['is_email_verified'], 'roles', 'permissions'
        ], $result->json());
    }

    /**
     * @covers \App\Actions\Auth\GetAuthUser::asController
     */
    public function testUnauthorized(): void
    {
        $result = $this->getJson(route(RouteEnum::USERS_ME->value));
        $result->assertStatus(401);
        $result->assertExactJson([
            'message' => 'Unauthenticated.'
        ], $result->json());
    }
}