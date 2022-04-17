<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\ResetPassword;
use App\Actions\Users\CreateUser;
use App\Events\Users\ResetPasswordEvent;
use App\Listeners\UserListener;
use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Event;

final class ResetPasswordTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Actions\Auth\ResetPassword::handle
     * @covers \App\Events\Users\ResetPasswordEvent
     * @covers \App\Listeners\UserListener::resetPassword
     */
    public function testSuccessfulUserCreation(): void
    {
        $this->expectsEvents([ResetPasswordEvent::class]);
        $user = CreateUser::make()->handle('first', 'last', 'test@test.com', 'testasdf');
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
        Event::assertDispatched(UserListener::class);
        Event::assertDispatched(ResetPasswordNotification::class);

    }
}