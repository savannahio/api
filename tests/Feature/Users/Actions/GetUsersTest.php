<?php

declare(strict_types=1);

namespace Tests\Feature\Users\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetUsersTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_LIST->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Users\Actions\GetUsers::asController
     */
    public function testCanListUsers(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_USERS->value]);
        $uri = route(name: RouteEnum::USERS_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Users\Actions\GetUsers::asController
     * @covers \App\Users\Actions\GetUsers::rules
     */
    public function testCannotListUsers(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }
}
