<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\CreateUser;
use App\Auth\Enum\PermissionEnum;
use App\Auth\Enum\RoleEnum;
use App\Auth\Models\Permission;
use App\Auth\Models\Role;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateUserTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Actions\CreateUser::handle
     */
    public function testSuccessfulUserCreation(): void
    {
        $user = parent::createUser();
        static::assertInstanceOf(User::class, $user);
    }

    /**
     * @covers \App\Users\Actions\CreateUser::handle
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
     * @covers \App\Users\Actions\CreateUser::asCommand
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
