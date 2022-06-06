<?php

namespace Tests\Unit\Events;

use App\Actions\Users\UpdateUser;
use App\Actions\Users\VerifyEmail;
use App\Events\Users\UserUpdatedEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Event;

class UserUpdatedEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserUpdatedEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        UpdateUser::make()->handle($user, 'asdfasdfasdf');
        Event::assertDispatched(UserUpdatedEvent::class, function (UserUpdatedEvent $e) use ($user) {
            $this->assertEquals('UserUpdatedEvent', $e->broadcastAs());
            $this->assertEquals($e->user->id, $user->id);
            $this->assertEquals($e->broadcastOn()->name,  'private-users.'.$user->id);
            return $e->user->id === $user->id;
        });
    }

}