<?php

declare(strict_types=1);

namespace App\Actions\Payments;

use App\Models\Users\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Stripe\Customer;
use Stripe\StripeClient;

class CreateCustomer
{
    use AsAction;

    public function handle(User $user): User
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $request = self::getCustomerRequest($user);

        $customer = $stripe->customers->create($request->jsonSerialize());
        $user->payments_id = $customer->id;
        $user->save();

        return $user;
    }

    private function getCustomerRequest(User $user): Customer
    {
        $customer = new Customer();
        $customer->name = $user->first_name.' '.$user->last_name;
        $customer->email = $user->email;

        return $customer;
    }
}
