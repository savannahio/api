<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Actions\Auth\ResetPassword;
use App\Events\Users\ResetPasswordEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

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
        $this->expectsEvents([ResetPasswordEvent::class]);
        $user = parent::createUser();
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
    }
}
