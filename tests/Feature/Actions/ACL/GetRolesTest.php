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
final class GetRolesTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function testRequiresAuthentication(): void
    {
        $uri = route(name: RouteEnum::ROLES_LIST->value);
        $result = $this->getJson($uri);
        $result->assertStatus(401);
    }

    /**
     * @covers \App\Actions\ACL\GetRoles::asController
     * @covers \App\Actions\ACL\GetRoles::handle
     */
    public function testSuccessfulGet(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_ROLES->value]);
        $uri = route(name: RouteEnum::ROLES_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }

    /**
     * @covers \App\Actions\ACL\GetRoles::asController
     * @covers \App\Actions\ACL\GetRoles::handle
     */
    public function testUnauthorized(): void
    {
        $user = parent::createUser();
        $uri = route(name: RouteEnum::ROLES_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(403);
    }

    /**
     * @covers \App\Actions\ACL\GetRoles::asController
     * @covers \App\Actions\ACL\GetRoles::rules
     */
    public function testValidationErrors(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_ROLES->value]);
        $uri = route(name: RouteEnum::ROLES_LIST->value, parameters: ['page' => 'asdfasdf']);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(422);
    }
}
