<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Models;

use App\Auth\Enum\PermissionEnum;
use App\Auth\Models\Permission;
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
     * @covers \App\Auth\Models\Permission::toArray
     */
    public function testToArray(): void
    {
        $role = Permission::findByName(PermissionEnum::UPDATE_USER_ROLES->value);
        static::assertArrayHasKey('id', $role->toArray());
        static::assertArrayHasKey('name', $role->toArray());
    }
}
