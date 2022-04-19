<?php

declare(strict_types=1);

namespace App\Actions\Payments;

use App\Models\Support\Address;
use App\Users\Models\User;
use Config;
use JetBrains\PhpStorm\ArrayShape;
use Lorisleiva\Actions\Concerns\AsAction;
use Stripe\StripeClient;

class UpdateCustomer
{
    use AsAction;

    public function handle(User $user): void
    {
        if ('testing' === Config::get('app.env')) {
            return;
        }

        $stripe = new StripeClient(Config::get('services.stripe'));
        $request = CreateCustomer::make()->getCustomerRequest($user);
        $default_address = $user->defaultAddress();
        if (null !== $default_address) {
            $request['address'] = self::getAddressRequest($default_address);
        }

        $stripe->customers->update($user->payments_id, $request);
    }

    #[ArrayShape(['city' => 'string', 'country' => 'string', 'line1' => 'string', 'line2' => 'null|string', 'postal_code' => 'string', 'state' => 'string'])]
    public function getAddressRequest(Address $address): array
    {
        return [
            'city' => $address->city,
            'country' => $address->country,
            'line1' => $address->street1,
            'line2' => $address->street2,
            'postal_code' => $address->zip,
            'state' => $address->state,
        ];
    }
}
