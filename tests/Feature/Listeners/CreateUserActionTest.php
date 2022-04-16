<?php

declare(strict_types=1);

namespace Tests\Feature\Listeners;

use App\Actions\Users\CreateUser;
use App\Events\Users\UserRegisteredEvent;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistered(): void
    {
        $this->expectsEvents([UserRegisteredEvent::class]);
        $user = CreateUser::make()->handle('first', 'last', 'test@test.com', 'testasdf');
        static::assertInstanceOf(User::class, $user);
    }
}
