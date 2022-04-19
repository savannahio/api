<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Support\Traits;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class HasPaginatedInputTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Models\Support\Traits\HasPaginatedInput::getDirectionInput
     * @covers \App\Models\Support\Traits\HasPaginatedInput::getOrderBy
     * @covers \App\Models\Support\Traits\HasPaginatedInput::getPageInput
     * @covers \App\Models\Support\Traits\HasPaginatedInput::getPageValidationRules
     * @covers \App\Models\Support\Traits\HasPaginatedInput::getPerPageInput
     */
    public function test(): void
    {
        $user = parent::createUser(permissions: [PermissionEnum::VIEW_ROLES->value]);
        $uri = route(name: RouteEnum::ROLES_LIST->value);
        $this->actingAs($user);
        $result = $this->getJson($uri);
        $result->assertStatus(200);
    }
}
