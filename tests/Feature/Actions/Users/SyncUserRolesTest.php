<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\ACL\Enum\RoleEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class SyncUserRolesTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_ROLES_UPDATE->value, parameters: ['user' => 2343]);
        $result = $this->putJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\Users\SyncUserRoles::asController
     * @covers \App\Actions\Users\SyncUserRoles::rules
     */
    public function testCanUpdateOtherUserRoles(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_ROLES->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_ROLES_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'roles' => [RoleEnum::DEVELOPER->value],
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\SyncUserRoles::asController
     * @covers \App\Actions\Users\SyncUserRoles::rules
     */
    public function testValidationFailure(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_ROLES->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_ROLES_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'roles' => ['asdfasfd', 'asdfasdf'],
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(422);
    }

    /**
     * @covers \App\Actions\Users\SyncUserRoles::asController
     * @covers \App\Actions\Users\SyncUserRoles::rules
     */
    public function testCannotUpdateOtherUserRoles(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_ROLES_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'roles' => [RoleEnum::DEVELOPER->value],
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(403);
    }
}
