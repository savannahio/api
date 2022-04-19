<?php

namespace Tests\Unit\Actions\Payments;

use App\Actions\Payments\UpdateCustomerAddress;
use App\Models\Support\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;
use Config;


class UpdateCustomerAddressTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Payments\UpdateCustomerAddress::getAddressRequest
     * @covers \App\Actions\Payments\UpdateCustomerAddress::handle
     */
    public function testDoesCallApi(): void
    {
        Config::set('app.env', 'local');
        $user = parent::createUser();
        $address = Address::factory()->create();
        $user->setDefaultAddress($address);
        UpdateCustomerAddress::make()->handle($user, $address);
        $address_request = UpdateCustomerAddress::make()->getAddressRequest($address);
        static::assertArrayHasKey('city', $address_request);
        static::assertArrayHasKey('country', $address_request);
        static::assertArrayHasKey('line1', $address_request);
        static::assertArrayHasKey('line2', $address_request);
        static::assertArrayHasKey('postal_code', $address_request);
        static::assertArrayHasKey('state', $address_request);
    }
}