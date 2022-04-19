<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Events\Users\UserRegisteredEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

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
        $this->expectsEvents([UserRegisteredEvent::class]);
        parent::createUser();
    }
}
