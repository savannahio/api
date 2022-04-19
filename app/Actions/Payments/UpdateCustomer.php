<?php

declare(strict_types=1);

namespace App\Actions\Payments;

use App\Models\Support\Address;
use App\Models\Users\User;
use JetBrains\PhpStorm\ArrayShape;
use Lorisleiva\Actions\Concerns\AsAction;
use Stripe\StripeClient;
use Config;

class UpdateCustomerAddress
{
    use AsAction;

    public function handle(User $user, Address $address): void
    {
        \Log::info('env stuff ' . Config('app.env'));
        \Log::info('customer id ' . $user->payments_id);
        if ('testing' === Config('app.env')) {
            return;
        }

        $stripe = new StripeClient(Config::get('services.stripe'));
        $request = [
            'address' => self::getAddressRequest($address)
        ];

        $stripe->customers->update($user->payments_id, $request);
    }

    #[ArrayShape(['city' => "string", 'country' => "string", 'line1' => "string", 'line2' => "null|string", 'postal_code' => "string", 'state' => "string"])]
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
