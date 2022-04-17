<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\CreateUser;
use App\Events\Users\UserRegisteredEvent;
use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RoleEnum;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class TestCreateUser extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    public function testSuccessfulUserCreation(): void
    {
        $this->expectsEvents([UserRegisteredEvent::class]);
        $user = CreateUser::make()->handle('first', 'last', 'test@test.com', 'testasdf');
        static::assertInstanceOf(User::class, $user);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    public function testSuccessfulUserCreationWithRolesAndPermissions(): void
    {
        $this->expectsEvents([UserRegisteredEvent::class]);
        $user = CreateUser::make()->handle('first', 'last', 'test@test.com', 'testasdf', [RoleEnum::ADMIN->value], [PermissionEnum::VIEW_PERMISSIONS->value]);
        static::assertInstanceOf(User::class, $user);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::asCommand
     */
    public function testConsoleCommand(): void
    {
        $this->expectsEvents([UserRegisteredEvent::class]);
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
