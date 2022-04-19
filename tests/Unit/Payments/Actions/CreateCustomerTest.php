<?php

declare(strict_types=1);

namespace Tests\Unit\Actions\Payments;

use App\Payments\Actions\CreateCustomer;
use App\Users\Models\User;
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
     * @covers \App\Payments\Actions\CreateCustomer::getCustomerRequest
     * @covers \App\Payments\Actions\CreateCustomer::handle
     */
    public function testDoesNotCallStripeApi(): void
    {
        $user = parent::createUser();
        $user = CreateCustomer::make()->handle($user);
        static::assertInstanceOf(User::class, $user);

        static::assertNull($user->payments_id);
    }

    /**
     * @covers \App\Payments\Actions\CreateCustomer::getCustomerRequest
     * @covers \App\Payments\Actions\CreateCustomer::handle
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
