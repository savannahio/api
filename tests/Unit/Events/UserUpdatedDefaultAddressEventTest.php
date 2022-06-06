<?php

declare(strict_types=1);

namespace Tests\Unit\Events;

use App\Actions\Users\UpdateUserDefaultAddress;
use App\Events\Users\UserUpdatedEvent;
use App\Models\Support\Address;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserUpdatedDefaultAddressEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserUpdatedEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        $request = Address::factory()->make()->toArray();
        UpdateUserDefaultAddress::make()->handle(
            user: $user,
            name: $request['name'],
            street1: $request['street1'],
            city: $request['city'],
            state: $request['state'],
            zip: $request['zip'],
            country: $request['country'],
            street2: $request['street2'],
        );
        Event::assertDispatched(UserUpdatedEvent::class, function (UserUpdatedEvent $e) use ($user) {
            $this->assertEquals($e->user->id, $user->id);
            return $e->user->id === $user->id;
        });
    }
}
