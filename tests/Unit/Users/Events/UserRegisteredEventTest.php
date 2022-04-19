<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Events;

use App\Users\Events\UserRegisteredEvent;
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
     * @covers \App\Users\Events\UserRegisteredEvent
     */
    public function testEvents(): void
    {
        $this->expectsEvents([UserRegisteredEvent::class]);
        parent::createUser();
    }
}
