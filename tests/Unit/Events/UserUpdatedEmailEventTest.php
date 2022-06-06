<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Actions\Users\UpdateUser;
use App\Events\Users\UserUpdatedEmailEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Event;

/**
 * @internal
 * @coversNothing
 */
final class UserUpdatedEmailEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserUpdatedEmailEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser(email: 'zzzz@zzzz.com');
        UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
        Event::assertDispatched(UserUpdatedEmailEvent::class, function (UserUpdatedEmailEvent $e) use ($user) {
            $this->assertEquals('UserUpdatedEmailEvent', $e->broadcastAs());
            $this->assertEquals($e->user->id, $user->id);
            $this->assertEquals($e->broadcastOn()->name,  'private-users.'.$user->id);
            return $e->user->id === $user->id;
        });
    }
}
