<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\UpdateUserDefaultAddress;
use App\Locations\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateUserDefaultAddressTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Locations\Actions\CreateAddress::handle
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::handle
     */
    public function testCreation(): void
    {
        $user = parent::createUser();
        $request = Address::factory()->make()->toArray();
        $address = UpdateUserDefaultAddress::make()->handle(
            user: $user,
            name: $request['name'],
            street1: $request['street1'],
            city: $request['city'],
            state: $request['state'],
            zip: $request['zip'],
            country: $request['country'],
            street2: $request['street2'],
        );
        static::assertInstanceOf(Address::class, $address);
    }

    /**
     * @covers \App\Locations\Actions\CreateAddress::handle
     * @covers \App\Locations\Actions\UpdateAddress::handle
     * @covers \App\Users\Actions\UpdateUserDefaultAddress::handle
     */
    public function testUpdaate(): void
    {
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
        $address = UpdateUserDefaultAddress::make()->handle(
            user: $user,
            name: $request['name'],
            street1: $request['street1'],
            city: $request['city'],
            state: $request['state'],
            zip: $request['zip'],
            country: $request['country'],
            street2: $request['street2'],
        );
        static::assertInstanceOf(Address::class, $address);
    }
}
