<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\SyncUserPermissions;
use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class SyncUserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\SyncUserPermissions::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $permissions = SyncUserPermissions::make()->handle($user, [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        self::assertInstanceOf(Collection::class, $permissions);
        self::assertInstanceOf(Permission::class, $permissions[0]);
    }

    /**
     * @covers \App\Actions\Users\SyncUserPermissions::handle
     */
    public function testRemoveAllPermissions(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        $permissions = SyncUserPermissions::make()->handle($user, []);
        self::assertInstanceOf(Collection::class, $permissions);
        self::assertEquals(0, $permissions->count());
    }


}
