<?php

namespace Tests\Unit\Models\Support;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PermissionTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Models\Support\Permission::toArray
     */
    public function testToArray(): void
    {
        $role = Permission::findByName(PermissionEnum::UPDATE_USER_ROLES->value);
        $this->assertArrayHasKey('id', $role->toArray());
        $this->assertArrayHasKey('name', $role->toArray());
    }

}