<?php

declare(strict_types=1);

namespace Tests;

use App\Actions\Users\CreateUser;
use App\Models\ACL\Enum\RoleEnum;
use App\Models\Users\User;
use Database\Seeders\ACLSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ACLSeeder::class);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    protected function createUser(string $first_name = 'first', string $last_name = 'last', string $email = 'test@test.com', string $password = 'asdfasdea', array $roles = [], array $permissions = []): User
    {
        return CreateUser::make()->handle($first_name, $last_name, $email, $password, $roles, $permissions);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    protected function createSecondUser(string $first_name = 'first', string $last_name = 'last', string $email = 'aaasdf@teststuff.com', string $password = 'asdfasdea', array $roles = [], array $permissions = []): User
    {
        return CreateUser::make()->handle($first_name, $last_name, $email, $password, $roles, $permissions);
    }

    /**
     * @covers \App\Actions\Users\CreateUser::handle
     */
    protected function createAdminUser(): User
    {
        return CreateUser::make()->handle('first', 'last', 'something@whatever.com', 'testasdf', [RoleEnum::ADMIN->value]);
    }
}
