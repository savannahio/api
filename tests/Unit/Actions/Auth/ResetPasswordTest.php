<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ResetPassword;
use App\Events\Users\ResetPasswordEvent;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResetPasswordTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\ResetPassword::handle
     */
    public function testSamePassword(): void
    {
        $new_password = 'asdfasdfadsasdf';
        $user = parent::createUser(password: $new_password);
        ResetPassword::make()->handle($user, $new_password);
        $result = $user->newPasswordEquals($new_password);
        static::assertTrue($result);
    }

    /**
     * @covers \App\Actions\Auth\ResetPassword::handle
     */
    public function testDifferentPassword(): void
    {
        Event::fake();
        $new_password = 'asdfasdfadsasdf';
        $user = parent::createUser();
        ResetPassword::make()->handle($user, $new_password);
        $result = $user->newPasswordEquals($new_password);
        static::assertTrue($result);
        Event::assertDispatched(ResetPasswordEvent::class, fn (ResetPasswordEvent $event) => $event->user->id === $user->id);
    }
}
