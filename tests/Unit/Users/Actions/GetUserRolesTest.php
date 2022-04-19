<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\GetUserRoles;
use App\Auth\Enum\RoleEnum;
use App\Auth\Models\Permission;
use App\Auth\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetUserRolesTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Actions\GetUserRoles::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser(roles: [RoleEnum::USER_MANAGEMENT->value]);
        $roles = GetUserRoles::make()->handle($user);
        static::assertInstanceOf(Collection::class, $roles);
        static::assertInstanceOf(Role::class, $roles[0]);
        static::assertInstanceOf(Collection::class, $roles[0]->permissions);
        static::assertInstanceOf(Permission::class, $roles[0]->permissions[0]);
    }
}
