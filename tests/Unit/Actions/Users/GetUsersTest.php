<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\ShowUser;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShowUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\ShowUser::handle
     */
    public function testSuccess(): void
    {
        $user_a = parent::createUser(email: 'asdfasdf@sadfasdf.com');
        $user_b = ShowUser::make()->handle($user_a);
        self::assertInstanceOf(User::class, $user_b);
        self::assertEquals($user_a->id, $user_b->id);
    }


}
