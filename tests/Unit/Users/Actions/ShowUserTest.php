<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\ShowUser;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShowUserTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Actions\ShowUser::handle
     */
    public function testSuccess(): void
    {
        $user_a = parent::createUser(email: 'asdfasdf@sadfasdf.com');
        $user_b = ShowUser::make()->handle($user_a);
        static::assertInstanceOf(User::class, $user_b);
        static::assertSame($user_a->id, $user_b->id);
    }
}
