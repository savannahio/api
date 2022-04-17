<?php

namespace Tests\Unit\Models\Support\Enum;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HasEnumCasesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Models\Support\Traits\HasEnumCases::values
     * @covers \App\Models\Support\Traits\HasEnumCases::names
     * @covers \App\Models\Support\Traits\HasEnumCases::array
     */
    public function testPermissionEnum(): void
    {
        $this->assertIsArray(PermissionEnum::values());
        $this->assertIsArray(PermissionEnum::names());
        $this->assertIsArray(PermissionEnum::array());
    }

    /**
     * @covers \App\Models\Support\Traits\HasEnumCases::values
     * @covers \App\Models\Support\Traits\HasEnumCases::names
     * @covers \App\Models\Support\Traits\HasEnumCases::array
     */
    public function testRoleEnum(): void
    {
        $this->assertIsArray(RoleEnum::values());
        $this->assertIsArray(RoleEnum::names());
        $this->assertIsArray(RoleEnum::array());
    }
}