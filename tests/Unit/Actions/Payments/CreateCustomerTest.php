<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Payments;

use App\Actions\Payments\CreateCustomer;
use App\Models\Users\User;
use Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\UnitTestCase;

/**
 * @internal
 * @coversNothing
 */
final class CreateCustomerTest extends UnitTestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Actions\Payments\CreateCustomer::getCustomerRequest
     * @covers \App\Actions\Payments\CreateCustomer::handle
     */
    public function testDoesNotCallStripeApi(): void
    {
        $user = parent::createUser();
        $user = CreateCustomer::make()->handle($user);
        static::assertInstanceOf(User::class, $user);

        static::assertNull($user->payments_id);
    }

    /**
     * @covers \App\Actions\Payments\CreateCustomer::getCustomerRequest
     * @covers \App\Actions\Payments\CreateCustomer::handle
     */
    public function testDoesCallStripeApi(): void
    {
        Config::set('app.env', 'local');
        $user = parent::createUser();
        $user->refresh();
        static::assertInstanceOf(User::class, $user);
        static::assertNotNull($user->payments_id);
    }
}
