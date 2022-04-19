<?php

namespace Tests\Unit\Notifications\User;

use App\Actions\Auth\ResetPassword;
use App\Notifications\User\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Notification;

class ResetPasswordNotificationTest extends UnitTestCase
{

    use RefreshDatabase;

    /**
     * @covers \App\Notifications\User\ResetPasswordNotification::via
     * @covers \App\Notifications\User\ResetPasswordNotification::toMail
     */
    public function testChannels(): void
    {
        Notification::fake();
        $user = parent::createUser(password: 'zzzzzzzzz');
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
        Notification::assertSentTo($user, ResetPasswordNotification::class, function (ResetPasswordNotification $notification, $channels) {
            return in_array('mail', $channels);
        });
    }

}