<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Actions\Auth\ResetPassword;
use App\Events\Users\ResetPasswordEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Event;

/**
 * @internal
 * @coversNothing
 */
final class ResetPasswordEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\ResetPasswordEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
        Event::assertDispatched(ResetPasswordEvent::class, function (ResetPasswordEvent $e) use ($user) {
            $this->assertEquals($e->user->id, $user->id);
            return $e->user->id === $user->id;
        });
    }
}
