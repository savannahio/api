<?php

namespace Tests\Unit\Models\Support;

use App\Models\Support\Enum\RoleEnum;
use App\Models\Support\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RoleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Models\Support\Role::toArray
     * @covers \App\Models\Support\Enum\RoleEnum
     */
    public function testToArray(): void
    {
        $role = Role::findByName(RoleEnum::ADMIN->value);
        $this->assertArrayHasKey('id', $role->toArray());
        $this->assertArrayHasKey('name', $role->toArray());
    }

}