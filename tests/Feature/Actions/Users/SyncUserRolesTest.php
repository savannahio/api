<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\Users;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SyncUserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\SyncUserPermissions::asController
     * @covers \App\Actions\Users\SyncUserPermissions::rules
     */
    public function testCanUpdateOtherUserPermissions(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::UPDATE_USER_PERMISSIONS->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(RouteEnum::USERS_PERMISSIONS_UPDATE->value, ['user' => $user_b->id]);
        $request = [
            'permissions' => [PermissionEnum::VIEW_API_DOCUMENTATION->value]
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\SyncUserPermissions::asController
     * @covers \App\Actions\Users\SyncUserPermissions::rules
     */
    public function testCannotUpdateOtherUserPermissions(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(RouteEnum::USERS_PERMISSIONS_UPDATE->value, ['user' => $user_b->id]);
        $request = [
            'permissions' => [PermissionEnum::VIEW_API_DOCUMENTATION->value]
        ];
        $this->actingAs($user_a);
        $result = $this->putJson($uri, $request);
        $result->assertStatus(403);
    }

}
