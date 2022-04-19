<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Notifications;

use App\Users\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ResetPasswordNotificationTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Notifications\ResetPasswordNotification::toMail
     * @covers \App\Users\Notifications\ResetPasswordNotification::via
     */
    public function testSuccessfulNotification(): void
    {
        Notification::fake();
        $user = parent::createUser(password: 'zzzzzzzzz');
        $user->notify(new ResetPasswordNotification());
        Notification::assertSentTo($user, ResetPasswordNotification::class, function (ResetPasswordNotification $notification, $channels) use ($user) {
            $mailData = $notification->toMail($user);
            $this->assertSame('Password Reset', $mailData->subject);
            $this->assertStringContainsString('Your password was just reset.', $mailData->render()->__toString());
            $this->assertTrue(\in_array('mail', $channels, true));

            return true;
        });
    }
}
