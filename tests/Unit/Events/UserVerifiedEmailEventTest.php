<?php

namespace Tests\Unit\Events;

use App\Actions\Users\VerifyEmail;
use App\Events\Users\UserVerifiedEmailEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Tests\Unit\UnitTestCase;
use Event;

class UserVerifiedEmailEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserVerifiedEmailEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        VerifyEmail::make()->handle($user);
        Event::assertDispatched(UserVerifiedEmailEvent::class, function (UserVerifiedEmailEvent $e) use ($user) {
            $this->assertEquals('UserVerifiedEmailEvent', $e->broadcastAs());
            $this->assertEquals($e->user->id, $user->id);
            $this->assertEquals($e->broadcastOn()->name,  'private-users.'.$user->id);
            return $e->user->id === $user->id;
        });
    }
}