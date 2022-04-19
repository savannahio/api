<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Events;

use App\Users\Actions\UpdateUser;
use App\Users\Events\UserUpdatedEmailEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserUpdatedEmailEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Events\UserUpdatedEmailEvent
     */
    public function testEvents(): void
    {
        $this->expectsEvents([UserUpdatedEmailEvent::class]);
        $user = parent::createUser(email: 'zzzz@zzzz.com');
        UpdateUser::make()->handle($user, first_name: 'asdfasfasdfasdf', last_name: 'asdfasdf', email: 'asd@asdfasdf.com');
    }
}
