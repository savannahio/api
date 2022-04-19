<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\GetUserPermissions;
use App\Models\ACL\Enum\PermissionEnum;
use App\Models\ACL\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetUserPermissionsTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\GetUserPermissions::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        $permissions = GetUserPermissions::make()->handle($user);
        static::assertInstanceOf(Collection::class, $permissions);
        static::assertInstanceOf(Permission::class, $permissions[0]);
    }
}
