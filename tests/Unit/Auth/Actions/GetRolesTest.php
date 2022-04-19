<?php

declare(strict_types=1);

namespace Tests\Unit\Auth\Actions;

use App\Auth\Actions\GetRoles;
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
     * @covers \App\Auth\Actions\GetRoles::handle
     */
    public function testSuccessfulGet(): void
    {
        $result = GetRoles::make()->handle(page: 3);
        static::assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
