<?php

declare(strict_types=1);

namespace Tests\Feature\Actions\ACL;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetPermissionsTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::PERMISSIONS_LIST->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\ACL\GetPermissions::asController
     * @covers \App\Actions\ACL\GetPermissions::handle
     */
    public function testSuccessfulGet(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_PERMISSIONS->value]);
        $uri = route(name: RouteEnum::PERMISSIONS_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\ACL\GetPermissions::asController
     * @covers \App\Actions\ACL\GetPermissions::handle
     */
    public function testUnauthorized(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::PERMISSIONS_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }

    /**
     * @covers \App\Actions\ACL\GetPermissions::asController
     * @covers \App\Actions\ACL\GetPermissions::rules
     */
    public function testValidationErrors(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_PERMISSIONS->value]);
        $uri = route(name: RouteEnum::PERMISSIONS_LIST->value, parameters: ['page' => 'asdfasdf']);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(422);
    }
}
