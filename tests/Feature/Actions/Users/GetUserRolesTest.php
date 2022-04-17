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
final class GetUserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\GetUserPermissions::asController
     */
    public function testSuccessfulApiCall(): void
    {
        $user = parent::createUser();
        $uri = route(RouteEnum::USERS_PERMISSIONS_LIST->value, ['user' => $user->id]);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\GetUserPermissions::asController
     * @covers \App\Actions\Users\GetUserPermissions::rules
     */
    public function testCanViewOtherUserPermissions(): void
    {
        $user_a = parent::createUser(permissions: [PermissionEnum::VIEW_USER_PERMISSIONS->value]);
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(RouteEnum::USERS_PERMISSIONS_LIST->value, ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\Users\GetUserPermissions::asController
     * @covers \App\Actions\Users\GetUserPermissions::rules
     */
    public function testCannotViewOtherUserPermissions(): void
    {
        $user_a = parent::createUser();
        $user_b = parent::createUser(email: 'asdjdfkeas@asdf.com');
        $uri = route(RouteEnum::USERS_PERMISSIONS_LIST->value, ['user' => $user_b->id]);
        $this->actingAs($user_a);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }

}
