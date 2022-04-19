<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Support\Traits;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\ACL\Enum\RoleEnum;
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
     * @covers \App\Models\Support\Traits\HasEnumCases::array
     * @covers \App\Models\Support\Traits\HasEnumCases::names
     * @covers \App\Models\Support\Traits\HasEnumCases::values
     */
    public function testPermissionEnum(): void
    {
        static::assertIsArray(PermissionEnum::values());
        static::assertIsArray(PermissionEnum::names());
        static::assertIsArray(PermissionEnum::array());
    }

    /**
     * @covers \App\Models\Support\Traits\HasEnumCases::array
     * @covers \App\Models\Support\Traits\HasEnumCases::names
     * @covers \App\Models\Support\Traits\HasEnumCases::values
     */
    public function testRoleEnum(): void
    {
        static::assertIsArray(RoleEnum::values());
        static::assertIsArray(RoleEnum::names());
        static::assertIsArray(RoleEnum::array());
    }
}
