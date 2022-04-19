<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Actions\Users\DeleteUser;
use App\Models\Support\Address;
use App\Models\Users\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class DeleteUserTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Users\DeleteUser::handle
     */
    public function testSuccess(): void
    {
        $user = parent::createUser();
        $user_id = $user->id;
        DeleteUser::make()->handle($user);
        $deleted_user = User::find($user_id);
        static::assertNull($deleted_user);
    }

    public function testSoftDeletes(): void
    {
        $user = parent::createUser();
        $user_id = $user->id;
        DeleteUser::make()->handle($user);
        $deleted_user = User::withTrashed()->find($user_id);
        static::assertNotNull($deleted_user);
        static::assertNotNull($deleted_user->deleted_at);
    }

    public function testDeletesRelatedAddresses(): void
    {
        $user = parent::createUser();
        $address = Address::factory()->create();
        $user->setDefaultAddress($address);
        $address_id = $address->id;

        DeleteUser::make()->handle($user);
        $deleted_address = Address::find($address_id);
        static::assertNull($deleted_address);
    }
}
