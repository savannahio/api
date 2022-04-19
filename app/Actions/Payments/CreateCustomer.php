<?php

declare(strict_types=1);

namespace App\Actions\Payments;

use App\Models\Users\User;
use Config;
use Lorisleiva\Actions\Concerns\AsAction;
use Stripe\StripeClient;

class CreateCustomer
{
    use AsAction;

    public function handle(User $user): User
    {
        if ('testing' === Config::get('app.env')) {
            return $user;
        }

        $stripe = new StripeClient(Config::get('services.stripe'));
        $request = self::getCustomerRequest($user);

        $customer = $stripe->customers->create($request);
        $user->payments_id = $customer->id;
        $user->save();

        return $user;
    }

    public function getCustomerRequest(User $user): array
    {
        return [
            'name' => $user->first_name.' '.$user->last_name,
            'email' => $user->email,
        ];
    }
}
