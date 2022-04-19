<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Users;

use App\Users\Actions\ShowUserDefaultAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ShowUserDefaultAddressTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Users\Actions\ShowUserDefaultAddress::handle
     */
    public function testHandle(): void
    {
        $user = parent::createUser();
        $address = ShowUserDefaultAddress::make()->handle($user);
        static::assertNull($address);
    }
}
