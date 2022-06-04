<?php

namespace Tests\Unit\Events;

use App\Actions\Users\VerifyEmail;
use App\Events\Users\UserRolesUpdatedEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Event;

class UserRolesUpdatedEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserRolesUpdatedEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        VerifyEmail::make()->handle($user);
        Event::assertDispatched(UserRolesUpdatedEvent::class, function (UserRolesUpdatedEvent $e) use ($user) {
            $this->assertEquals('UserRolesUpdatedEvent', $e->broadcastAs());
            $this->assertEquals($e->user->id, $user->id);
            $this->assertEquals($e->broadcastOn()->name,  'private-users.'.$user->id);
            return $e->user->id === $user->id;
        });
    }
}