<?php

declare(strict_types=1);

namespace Tests\Unit\Users\Actions;

use App\Locations\Models\Address;
use App\Users\Actions\DeleteUser;
use App\Users\Models\User;
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
     * @covers \App\Users\Actions\DeleteUser::handle
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
