<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\CreateUser;
use App\Models\ACL\Enum\PermissionEnum;
use App\Models\ACL\Enum\RoleEnum;
use App\Models\ACL\Permission;
use App\Models\ACL\Role;
use App\Models\Users\User;
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
     * @covers \App\Actions\Users\CreateUser::handle
     */
    public function testSuccessfulUserCreation(): void
    {
        $user = parent::createUser();
        static::assertInstanceOf(User::class, $user);
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
