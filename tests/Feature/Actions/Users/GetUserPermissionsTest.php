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
final class GetUserPermissionsTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_LIST->value, parameters: ['user' => 2343]);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\Users\GetUserPermissions::asController
     */
    public function testSuccessfulApiCall(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_LIST->value, parameters: ['user' => $user->id]);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\GetUserPermissions::asController
     */
    public function testCanViewOtherUserPermissions(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::VIEW_USER_PERMISSIONS->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_LIST->value, parameters: ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\GetUserPermissions::asController
     */
    public function testCannotViewOtherUserPermissions(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_LIST->value, parameters: ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }
}
