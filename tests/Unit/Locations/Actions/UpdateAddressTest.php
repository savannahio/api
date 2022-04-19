<?php

declare(strict_types=1);

namespace Tests\Unit\Locations\Actions;

use App\Locations\Actions\CreateAddress;
use App\Locations\Actions\UpdateAddress;
use App\Locations\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateAddressTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Locations\Actions\UpdateAddress::make
     */
    public function testHandle(): void
    {
        $request = Address::factory()->make()->toArray();
        $address_create = CreateAddress::make()->handle(
            name: $request['name'],
            street1: $request['street1'],
            city: $request['city'],
            state: $request['state'],
            zip: $request['zip'],
            country: $request['country'],
            street2: $request['street2'],
        );
        $address_update = UpdateAddress::make()->handle(
            address: $address_create,
            name: $address_create->name,
            street1: $address_create->street1,
            city: $address_create->city,
            state: $address_create->state,
            zip: $address_create->zip,
            country: $address_create->country,
            street2: $address_create->street2,
        );
        static::assertInstanceOf(Address::class, $address_update);
    }
}
