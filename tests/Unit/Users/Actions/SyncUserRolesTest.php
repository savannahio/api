<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use App\Auth\Enum\RoleEnum;
use App\Auth\Models\Role;
use App\Users\Actions\SyncUserRoles;
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
     * @covers \App\Users\Actions\SyncUserRoles::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $roles = SyncUserRoles::make()->handle($user, [RoleEnum::DEVELOPER->value]);
        static::assertInstanceOf(Collection::class, $roles);
        static::assertInstanceOf(Role::class, $roles[0]);
    }

    /**
     * @covers \App\Users\Actions\SyncUserRoles::handle
     */
    public function testRemoveAllRoles(): void
    {
        $user = parent::createUser(roles: [RoleEnum::DEVELOPER->value]);
        $roles = SyncUserRoles::make()->handle($user, []);
        static::assertInstanceOf(Collection::class, $roles);
        static::assertSame(0, $roles->count());
    }
}
