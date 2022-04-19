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
final class SyncUserPermissionsTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_UPDATE->value, parameters: ['user' => 2342]);
        $result = $this->putJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Users\Actions\SyncUserPermissions::asController
     * @covers \App\Users\Actions\SyncUserPermissions::rules
     */
    public function testCanUpdateOtherUserPermissions(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_PERMISSIONS->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'permissions' => [PermissionEnum::VIEW_API_DOCUMENTATION->value],
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Users\Actions\SyncUserPermissions::asController
     * @covers \App\Users\Actions\SyncUserPermissions::rules
     */
    public function testCannotUpdateOtherUserPermissions(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(name: RouteEnum::USERS_PERMISSIONS_UPDATE->value, parameters: ['user' => $user_b->id]);
        $request = [
            'permissions' => [PermissionEnum::VIEW_API_DOCUMENTATION->value],
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(403);
    }
}
