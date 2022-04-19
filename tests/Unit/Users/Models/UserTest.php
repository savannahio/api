<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Models;

use App\Users\Builders\UserBuilder;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Models\User::newEloquentBuilder
     */
    public function testNewEloquentBuilder(): void
    {
        $qb = User::query();
        static::assertInstanceOf(UserBuilder::class, $qb);
    }

    /**
     * @covers \App\Users\Models\User::newPasswordEquals
     */
    public function testNewPasswordEquals(): void
    {
        $password = 'asdfasdffasdsdf';
        $user = parent::createUser(password: $password);
        $results = $user->newPasswordEquals('zzzzzzz');
        static::assertFalse($results);
    }

    /**
     * @covers \App\Users\Models\User::setPassword
     */
    public function testSetPassword(): void
    {
        $new_password = 'asdfasdffasdsdf';
        $user = parent::createUser();
        $user->setPassword($new_password);
        static::assertNotSame($new_password, $user->password);
    }

    /**
     * @covers \App\Users\Models\User::toArray
     */
    public function testToArray(): void
    {
        $user = parent::createUser();
        $array = $user->toArray();
        static::assertArrayHasKey('id', $array);
        static::assertArrayHasKey('first_name', $array);
        static::assertArrayHasKey('last_name', $array);
        static::assertArrayHasKey('email', $array);
    }

    /**
     * @covers \App\Users\Models\User::authToArray
     */
    public function testAuthToArray(): void
    {
        $user = parent::createUser();
        $array = $user->authToArray();
        static::assertArrayHasKey('id', $array);
        static::assertArrayHasKey('first_name', $array);
        static::assertArrayHasKey('last_name', $array);
        static::assertArrayHasKey('email', $array);
        static::assertArrayHasKey('meta', $array);
        static::assertArrayHasKey('is_email_verified', $array['meta']);
        static::assertArrayHasKey('roles', $array);
        static::assertArrayHasKey('permissions', $array);
    }
}
