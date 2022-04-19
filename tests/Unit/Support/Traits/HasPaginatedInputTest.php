<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Support\Traits;

use App\Auth\Enum\PermissionEnum;
use App\Support\Enum\RouteEnum;
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
     * @covers \App\Support\Traits\HasPaginatedInput::getDirectionInput
     * @covers \App\Support\Traits\HasPaginatedInput::getOrderBy
     * @covers \App\Support\Traits\HasPaginatedInput::getPageInput
     * @covers \App\Support\Traits\HasPaginatedInput::getPageValidationRules
     * @covers \App\Support\Traits\HasPaginatedInput::getPerPageInput
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
