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
final class GetUserRolesTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_ROLES_LIST->value, parameters: ['user' => 23423]);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Users\Actions\GetUserRoles::asController
     */
    public function testCanViewOwnRoles(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $uri = route(name: RouteEnum::USERS_ROLES_LIST->value, parameters: ['user' => $user->id]);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Users\Actions\GetUserRoles::asController
     */
    public function testCanViewOtherUserRoles(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::VIEW_USER_ROLES->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_ROLES_LIST->value, parameters: ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Users\Actions\GetUserRoles::asController
     */
    public function testCannotViewOtherUserRoles(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $this->actingAs($user_a);
        $uri = route(name: RouteEnum::USERS_ROLES_LIST->value, parameters: ['user' => $user_b->id]);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }
}
