<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\CreateUser;
use App\Events\Users\UserRegisteredEvent;
use App\Listeners\UserListener;
use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RoleEnum;
use App\Models\Support\Permission;
use App\Models\Support\Role;
use App\Models\Users\User;
use Event;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    public function testSuccessfulUserCreation(): void
    {
        $user = parent::createUser();
        static::assertInstanceOf(User::class, $user);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     * @covers \App\Events\Users\UserRegisteredEvent
     */
    public function testCreationEvents(): void
    {
        $this->expectsEvents([UserRegisteredEvent::class]);
        parent::createUser();
        Event::assertDispatched(UserListener::class);
        Event::assertDispatched(VerifyEmail::class);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    public function testSuccessfulUserCreationWithRolesAndPermissions(): void
    {
        $user = CreateUser::make()->handle('first', 'last', 'test@test.com', 'testasdf', [RoleEnum::ADMIN->value], [PermissionEnum::VIEW_PERMISSIONS->value]);
        static::assertInstanceOf(User::class, $user);
        static::assertSame(1, $user->roles()->count());
        static::assertSame(1, $user->permissions()->count());
        static::assertInstanceOf(Role::class, $user->roles[0]);
        static::assertInstanceOf(Permission::class, $user->permissions[0]);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::asCommand
     */
    public function testConsoleCommand(): void
    {
        $this->artisan('users:create', [
            'first_name' => 'first',
            'last_name' => 'last',
            'email' => 'test@test.com',
            'password' => 'testasdf',
        ])
            ->assertSuccessful()
        ;
    }
}
