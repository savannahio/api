<?php

namespace Tests\Unit\Events;

use App\Actions\Users\SyncUserPermissions;
use App\Events\Users\UserPermissionsUpdatedEvent;
use App\Models\ACL\Enum\PermissionEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Event;

class UserPermissionsUpdatedEventTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Events\Users\UserPermissionsUpdatedEvent
     */
    public function testEvents(): void
    {
        Event::fake();
        $user = parent::createUser();
        SyncUserPermissions::make()->handle($user, [PermissionEnum::VIEW_USER_PERMISSIONS->value]);
        Event::assertDispatched(UserPermissionsUpdatedEvent::class, function (UserPermissionsUpdatedEvent $e) use ($user) {
            $this->assertEquals('UserPermissionsUpdatedEvent', $e->broadcastAs());
            $this->assertEquals($e->user->id, $user->id);
            $this->assertEquals($e->broadcastOn()->name,  'private-users.'.$user->id);
            return $e->user->id === $user->id;
        });
    }
}