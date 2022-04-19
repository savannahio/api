<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\ACL;

use App\Actions\ACL\GetPermissions;
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
     * @covers \App\Actions\ACL\GetPermissions::handle
     */
    public function testSuccessfulGet(): void
    {
        $result = GetPermissions::make()->handle(page: 3);
        static::assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
