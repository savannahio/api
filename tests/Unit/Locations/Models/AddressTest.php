<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Support;

use App\Locations\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class AddressTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Locations\Models\Address::factory
     * @covers \App\Locations\Models\Address::toArray
     */
    public function testToArray(): void
    {
        $address = Address::factory()->create();
        $array = $address->toArray();
        static::assertArrayHasKey('id', $array);
        static::assertArrayHasKey('name', $array);
        static::assertArrayHasKey('street1', $array);
        static::assertArrayHasKey('street2', $array);
        static::assertArrayHasKey('city', $array);
        static::assertArrayHasKey('state', $array);
        static::assertArrayHasKey('zip', $array);
        static::assertArrayHasKey('country', $array);
    }

    /**
     * @covers \App\Locations\Models\Address::toArray
     */
    public function testToArrayWithPivot(): void
    {
        $user = parent::createUser();
        $address = Address::factory()->create();
        $user->setDefaultAddress($address);
        $default_address = $user->defaultAddress();
        $array = $default_address->toArray();
        static::assertArrayHasKey('is_default', $array);
        static::assertTrue($array['is_default']);
    }

    /**
     * @covers \App\Locations\Models\Address::users
     */
    public function testUsersMorphToMany(): void
    {
        $address = Address::factory()->create();
        static::assertInstanceOf(MorphToMany::class, $address->users());
    }
}
