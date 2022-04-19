<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Models;

use App\Auth\Enum\RoleEnum;
use App\Auth\Models\Role;
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
     * @covers \App\Auth\Enum\RoleEnum
     * @covers \App\Auth\Models\Role::toArray
     */
    public function testToArray(): void
    {
        $role = Role::findByName(RoleEnum::ADMIN->value);
        static::assertArrayHasKey('id', $role->toArray());
        static::assertArrayHasKey('name', $role->toArray());
    }
}
