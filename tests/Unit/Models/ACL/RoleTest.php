<?php

declare(strict_types=1);

namespace Tests\Unit\Models\ACL;

use App\Models\ACL\Enum\RoleEnum;
use App\Models\ACL\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class RoleTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Models\ACL\Enum\RoleEnum
     * @covers \App\Models\ACL\Role::toArray
     */
    public function testToArray(): void
    {
        $role = Role::findByName(RoleEnum::ADMIN->value);
        static::assertArrayHasKey('id', $role->toArray());
        static::assertArrayHasKey('name', $role->toArray());
    }
}
