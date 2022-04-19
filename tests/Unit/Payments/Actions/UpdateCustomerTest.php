<?php

declare(strict_types=1);

namespace Tests\Unit\Payments\Actions;

use App\Locations\Models\Address;
use App\Payments\Actions\CreateCustomer;
use App\Payments\Actions\UpdateCustomer;
use App\Users\Models\User;
use Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UpdateCustomerTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Payments\Actions\UpdateCustomer::handle
     */
    public function testHandleReturns(): void
    {
        $user = User::factory()->create();
        CreateCustomer::make()->handle($user);
        $address = Address::factory()->create();
        $user->setDefaultAddress($address);
        $user->refresh();
        UpdateCustomer::make()->handle($user);
        static::assertNull($user->payments_id);
    }

    /**
     * @covers \App\Payments\Actions\UpdateCustomer::handle
     */
    public function testHandle(): void
    {
        Config::set('app.env', 'local');

        $user = User::factory()->create();
        CreateCustomer::make()->handle($user);
        $address = Address::factory()->create();
        $user->setDefaultAddress($address);
        $user->refresh();
        UpdateCustomer::make()->handle($user);
        static::assertNotNull($user->payments_id);
    }

    /**
     * @covers \App\Payments\Actions\UpdateCustomer::getAddressRequest
     */
    public function testGetAddressRequest(): void
    {
        $address = Address::factory()->create();
        $address_request = UpdateCustomer::make()->getAddressRequest($address);
        static::assertArrayHasKey('city', $address_request);
        static::assertArrayHasKey('country', $address_request);
        static::assertArrayHasKey('line1', $address_request);
        static::assertArrayHasKey('line2', $address_request);
        static::assertArrayHasKey('postal_code', $address_request);
        static::assertArrayHasKey('state', $address_request);
    }
}
