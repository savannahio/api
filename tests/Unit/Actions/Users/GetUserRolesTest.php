<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\GetUserPermissions;
use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetUserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\GetUserPermissions::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        $permissions = GetUserPermissions::make()->handle($user);
        self::assertInstanceOf(LengthAwarePaginator::class, $permissions);
        self::assertInstanceOf(Permission::class, $permissions[0]);
    }


}
