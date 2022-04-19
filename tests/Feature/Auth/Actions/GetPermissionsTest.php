<?php

declare(strict_types=1);

namespace Tests\Feature\Auth\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Support\Enum\RouteEnum;
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
     * @covers \App\Auth\Actions\GetPermissions::asController
     * @covers \App\Auth\Actions\GetPermissions::handle
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
     * @covers \App\Auth\Actions\GetPermissions::asController
     * @covers \App\Auth\Actions\GetPermissions::handle
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
     * @covers \App\Auth\Actions\GetPermissions::asController
     * @covers \App\Auth\Actions\GetPermissions::rules
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
