<?php

declare(strict_types=1);

namespace Tests\Unit\Support\Traits;

use App\Auth\Enum\PermissionEnum;
use App\Auth\Enum\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class HasEnumCasesTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Support\Traits\HasEnumCases::array
     * @covers \App\Support\Traits\HasEnumCases::names
     * @covers \App\Support\Traits\HasEnumCases::values
     */
    public function testPermissionEnum(): void
    {
        static::assertIsArray(PermissionEnum::values());
        static::assertIsArray(PermissionEnum::names());
        static::assertIsArray(PermissionEnum::array());
    }

    /**
     * @covers \App\Support\Traits\HasEnumCases::array
     * @covers \App\Support\Traits\HasEnumCases::names
     * @covers \App\Support\Traits\HasEnumCases::values
     */
    public function testRoleEnum(): void
    {
        static::assertIsArray(RoleEnum::values());
        static::assertIsArray(RoleEnum::names());
        static::assertIsArray(RoleEnum::array());
    }
}
