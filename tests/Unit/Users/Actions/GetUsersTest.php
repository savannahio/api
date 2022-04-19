<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use App\Users\Actions\GetUsers;
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
     * @covers \App\Users\Actions\GetUsers::handle
     */
    public function testSuccess(): void
    {
        parent::createUser();
        $users = GetUsers::make()->handle();
        static::assertInstanceOf(LengthAwarePaginator::class, $users);
    }
}
