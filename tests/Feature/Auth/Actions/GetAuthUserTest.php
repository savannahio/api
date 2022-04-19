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
final class GetAuthUserTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_ME->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Auth\Actions\GetAuthUser::asController
     */
    public function testSuccessfulGet(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_ME->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
        $result->assertJsonStructure([
            'id', 'first_name', 'last_name', 'email', 'meta' => ['is_email_verified'], 'roles', 'permissions',
        ], $result->json());
    }

    /**
     * @covers \App\Auth\Actions\GetAuthUser::asController
     */
    public function testUnauthorized(): void
    {
        $uri = route(name: RouteEnum::USERS_ME->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
        $result->assertExactJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
