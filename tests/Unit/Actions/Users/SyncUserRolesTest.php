<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\SyncUserRoles;
use App\Models\ACL\Enum\RoleEnum;
use App\Models\ACL\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class SyncUserRolesTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\SyncUserRoles::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $roles = SyncUserRoles::make()->handle($user, [RoleEnum::DEVELOPER->value]);
        static::assertInstanceOf(Collection::class, $roles);
        static::assertInstanceOf(Role::class, $roles[0]);
    }

    /**
     * @covers \App\Actions\Users\SyncUserRoles::handle
     */
    public function testRemoveAllRoles(): void
    {
        $user = parent::createUser(roles: [RoleEnum::DEVELOPER->value]);
        $roles = SyncUserRoles::make()->handle($user, []);
        static::assertInstanceOf(Collection::class, $roles);
        static::assertSame(0, $roles->count());
    }
}
