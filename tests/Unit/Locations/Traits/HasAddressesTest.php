<?php

declare(strict_types=1);

namespace Tests\Unit\Locations\Traits;

use App\Locations\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class HasAddressesTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Locations\Traits\HasAddresses::addresses
     */
    public function testAddresses(): void
    {
        $user = parent::createUser();
        static::assertInstanceOf(MorphToMany::class, $user->addresses());
    }

    /**
     * @covers \App\Locations\Traits\HasAddresses::hasAddress
     */
    public function testHasAddress(): void
    {
        $user = parent::createUser();
        $address = Address::factory()->create();
        $has_address = $user->hasAddress($address);
        static::assertFalse($has_address);
    }

    /**
     * @covers \App\Locations\Traits\HasAddresses::defaultAddress
     */
    public function testDefaultAddress(): void
    {
        $user = parent::createUser();
        $default_address = $user->defaultAddress();
        static::assertNull($default_address);
    }

    /**
     * @covers \App\Locations\Traits\HasAddresses::setDefaultAddress
     */
    public function testSetDefaultAddressWhenNull(): void
    {
        $user = parent::createUser();
        $address = Address::factory()->create();
        $user->setDefaultAddress($address);
        static::assertSame(1, $user->addresses()->count());
    }

    /**
     * @covers \App\Locations\Traits\HasAddresses::setDefaultAddress
     */
    public function testSetDefaultAddressWhenNotNull(): void
    {
        $user = parent::createUser();
        $first_address = Address::factory()->create();
        $user->setDefaultAddress($first_address);

        $second_address = Address::factory()->create();
        $user->setDefaultAddress($second_address);

        $default_address = $user->defaultAddress();
        static::assertSame($second_address->id, $default_address->id);
        static::assertSame(2, $user->addresses()->count());
    }

    /**
     * @covers \App\Locations\Traits\HasAddresses::setDefaultAddress
     */
    public function testSetSameDefaultAddress(): void
    {
        $user = parent::createUser();
        $first_address = Address::factory()->create();
        $user->setDefaultAddress($first_address);
        $user->setDefaultAddress($first_address);

        $default_address = $user->defaultAddress();
        static::assertSame($first_address->id, $default_address->id);
    }
}
