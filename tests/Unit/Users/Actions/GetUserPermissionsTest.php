<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Auth\Models\Permission;
use App\Users\Actions\GetUserPermissions;
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
     * @covers \App\Users\Actions\GetUserPermissions::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        $permissions = GetUserPermissions::make()->handle($user);
        static::assertInstanceOf(Collection::class, $permissions);
        static::assertInstanceOf(Permission::class, $permissions[0]);
    }
}
