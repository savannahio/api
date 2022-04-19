<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\SyncUserPermissions;
use App\Auth\Enum\PermissionEnum;
use App\Auth\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class SyncUserPermissionsTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Actions\SyncUserPermissions::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $permissions = SyncUserPermissions::make()->handle($user, [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        static::assertInstanceOf(Collection::class, $permissions);
        static::assertInstanceOf(Permission::class, $permissions[0]);
    }

    /**
     * @covers \App\Users\Actions\SyncUserPermissions::handle
     */
    public function testRemoveAllPermissions(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        $permissions = SyncUserPermissions::make()->handle($user, []);
        static::assertInstanceOf(Collection::class, $permissions);
        static::assertSame(0, $permissions->count());
    }
}
