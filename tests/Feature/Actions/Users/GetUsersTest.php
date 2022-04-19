<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
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
     * @covers \App\Actions\Users\GetUsers::asController
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
     * @covers \App\Actions\Users\GetUsers::asController
     * @covers \App\Actions\Users\GetUsers::rules
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
