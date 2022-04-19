<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\Actions\Auth\ResetPassword;
use App\Actions\Users\UpdateUser;
use App\Actions\Users\UpdateUserDefaultAddress;
use App\Events\Users\UserUpdatedEvent;
use App\Listeners\UserListener;
use App\Models\Support\Address;
use App\Notifications\Users\ResetPasswordNotification;
use Event;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Notification;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserListenerTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Listeners\UserListener::resetPassword
     * @covers \App\Listeners\UserListener::subscribe
     */
    public function testResetPassword(): void
    {
        Notification::fake();
        $user = parent::createUser(password: 'zzzzzzzzz');
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    /**
     * @covers \App\Listeners\UserListener::registered
     * @covers \App\Listeners\UserListener::subscribe
     */
    public function testRegistered(): void
    {
        Notification::fake();
        $user = parent::createUser(email: 'zzzz@zzzz.com');
        UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @covers \App\Listeners\UserListener::subscribe
     * @covers \App\Listeners\UserListener::updatedEmail
     */
    public function testUpdatedEmail(): void
    {
        Notification::fake();
        $user = parent::createUser(email: 'zzzz@zzzz.com');
        UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @covers \App\Listeners\UserListener::subscribe
     * @covers \App\Listeners\UserListener::userUpdated
     */
    public function testUpdatedDefaultAddress(): void
    {
        $this->expectsEvents([UserUpdatedEvent::class]);
        $user = parent::createUser();
        $request = Address::factory()->make()->toArray();
        UpdateUserDefaultAddress::make()->handle(
            user: $user,
            name: $request['name'],
            street1: $request['street1'],
            city: $request['city'],
            state: $request['state'],
            zip: $request['zip'],
            country: $request['country'],
            street2: $request['street2'],
        );
        (new UserListener())->userUpdated(new UserUpdatedEvent($user));
        Event::assertDispatched(fn (UserUpdatedEvent $event) => $event->user->id === $user->id);
    }
}
