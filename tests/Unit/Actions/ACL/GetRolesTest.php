<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\ACL;

use App\Actions\ACL\GetRoles;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetRolesTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\ACL\GetRoles::handle
     */
    public function testSuccessfulGet(): void
    {
        $result = GetRoles::make()->handle(page: 3);
        static::assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
