<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\GetUsers;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GetUsersTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\GetUsers::handle
     */
    public function testSuccess(): void
    {
        parent::createUser();
        $users = GetUsers::make()->handle();
        static::assertInstanceOf(LengthAwarePaginator::class, $users);
    }
}
