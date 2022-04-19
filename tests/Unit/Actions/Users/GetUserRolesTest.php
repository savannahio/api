<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\GetUserRoles;
use App\Models\ACL\Enum\RoleEnum;
use App\Models\ACL\Permission;
use App\Models\ACL\Role;
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
     * @covers \App\Actions\Users\GetUserRoles::handle
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
