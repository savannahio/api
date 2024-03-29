<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Support;

use App\Actions\Support\CreateAddress;
use App\Models\Support\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateAddressTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Support\CreateAddress::handle
     */
    public function testCreation(): void
    {
        $request = Address::factory()->make()->toArray();
        $address = CreateAddress::make()->handle(
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
