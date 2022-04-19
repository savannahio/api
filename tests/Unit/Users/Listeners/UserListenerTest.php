<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\Auth\Actions\ResetPassword;
use App\Users\Actions\UpdateUser;
use App\Users\Actions\UpdateUserDefaultAddress;
use App\Users\Events\UserUpdatedEvent;
use App\Users\Listeners\UserListener;
use App\Locations\Models\Address;
use App\Users\Notifications\ResetPasswordNotification;
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
     * @covers \App\Users\Listeners\UserListener::resetPassword
     * @covers \App\Users\Listeners\UserListener::subscribe
     */
    public function testResetPassword(): void
    {
        Notification::fake();
        $user = parent::createUser(password: 'zzzzzzzzz');
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    /**
     * @covers \App\Users\Listeners\UserListener::registered
     * @covers \App\Users\Listeners\UserListener::subscribe
     */
    public function testRegistered(): void
    {
        Notification::fake();
        $user = parent::createUser(email: 'zzzz@zzzz.com');
        UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @covers \App\Users\Listeners\UserListener::subscribe
     * @covers \App\Users\Listeners\UserListener::updatedEmail
     */
    public function testUpdatedEmail(): void
    {
        Notification::fake();
        $user = parent::createUser(email: 'zzzz@zzzz.com');
        UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /**
     * @covers \App\Users\Listeners\UserListener::subscribe
     * @covers \App\Users\Listeners\UserListener::userUpdated
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
