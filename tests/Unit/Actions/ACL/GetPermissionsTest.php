<?php

namespace Tests\Feature\Actions\ACL;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetPermissionsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\ACL\GetPermissions::handle
     * @covers \App\Actions\ACL\GetPermissions::asController
     */
    public function testSuccessfulGet(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_PERMISSIONS->value]);
        $this->actingAs($user);
        $result = $this->getJson(route(RouteEnum::PERMISSIONS_LIST->value));
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\ACL\GetPermissions::handle
     * @covers \App\Actions\ACL\GetPermissions::asController
     */
    public function testUnauthorized(): void
    {
        $user = parent::createUser();
        $this->actingAs($user);
        $result = $this->getJson(route(RouteEnum::PERMISSIONS_LIST->value));
        $result->assertStatus(403);
    }

    /**
     * @covers \App\Actions\ACL\GetPermissions::asController
     * @covers \App\Actions\ACL\GetPermissions::rules
     */
    public function testValidationErrors(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_PERMISSIONS->value]);
        $this->actingAs($user);
        $result = $this->getJson(route(RouteEnum::PERMISSIONS_LIST->value, ['page' => 'asdfasdf']));
        $result->assertStatus(422);
    }
}