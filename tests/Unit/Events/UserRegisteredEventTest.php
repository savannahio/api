<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Events\Users\UserRegisteredEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Event;

/**
 * @internal
 * @coversNothing
 */
final class UserRegisteredEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserRegisteredEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        Event::assertDispatched(UserRegisteredEvent::class, function (UserRegisteredEvent $e) use ($user) {
            $this->assertEquals($e->user->id, $user->id);
            return $e->user->id === $user->id;
        });
    }
}
