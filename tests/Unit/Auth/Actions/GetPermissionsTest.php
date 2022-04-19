<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\ACL;

use App\Auth\Actions\GetPermissions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetPermissionsTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Auth\Actions\GetPermissions::handle
     */
    public function testSuccessfulGet(): void
    {
        $result = GetPermissions::make()->handle(page: 3);
        static::assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
