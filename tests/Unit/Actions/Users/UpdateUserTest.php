<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\UpdateUser;
use App\Events\Users\UserUpdatedEmailEvent;
use App\Listeners\UserListener;
use App\Models\Users\User;
use Event;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateUserTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\UpdateUser::handle
     */
    public function testSuccessfulUpdate(): void
    {
        $first_name = 'first';
        $last_name = 'last';
        $email = 'jon.doe@asdf.com';
        $user = User::factory()->create(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email]);
        $user = UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
        static::assertNotSame($first_name, $user->first_name);
        static::assertNotSame($last_name, $user->last_name);
        static::assertNotSame($email, $user->email);
    }

    /**
     * @covers \App\Actions\Users\UpdateUser::handle
     */
    public function testEventsDoNotFireWhenSameEmail(): void
    {
        $email = 'john.doe@asdf.com';
        $this->doesntExpectEvents([UserUpdatedEmailEvent::class]);
        $user = User::factory()->create(['email' => $email]);
        UpdateUser::make()->handle($user, email: $email);

        Event::assertNotDispatched(UserListener::class);
        Event::assertNotDispatched(VerifyEmail::class);
    }
}
