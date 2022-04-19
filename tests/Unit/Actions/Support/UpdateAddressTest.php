<?php

namespace Tests\Unit\Actions\Support;

use App\Actions\Support\CreateAddress;
use App\Models\Support\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAddressTest extends TestCase
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
        $this->assertInstanceOf(Address::class, $address);
    }
}