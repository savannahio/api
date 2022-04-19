<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Events;

use App\Auth\Actions\ResetPassword;
use App\Users\Events\ResetPasswordEvent;
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
     * @covers \App\Users\Events\ResetPasswordEvent
     */
    public function testEvents(): void
    {
        $this->expectsEvents([ResetPasswordEvent::class]);
        $user = parent::createUser();
        ResetPassword::make()->handle($user, 'asdfasdfadsasdf');
    }
}
