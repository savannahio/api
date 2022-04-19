<?php

declare(strict_types=1);

namespace Tests\Unit\Models\ACL;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\ACL\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class PermissionTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Models\ACL\Permission::toArray
     */
    public function testToArray(): void
    {
        $role = Permission::findByName(PermissionEnum::UPDATE_USER_ROLES->value);
        static::assertArrayHasKey('id', $role->toArray());
        static::assertArrayHasKey('name', $role->toArray());
    }
}
