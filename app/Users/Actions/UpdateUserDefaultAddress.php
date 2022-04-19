<?php

declare(strict_types=1);

namespace App\Users\Actions;

use App\Locations\Actions\CreateAddress;
use App\Locations\Actions\UpdateAddress;
use App\Locations\Models\Address;
use App\Users\Events\UserUpdatedEvent;
use App\Users\Models\User;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserDefaultAddress
{
    use AsAction;

    public function handle(User $user, string $name, string $street1, string $city, string $state, string $zip, string $country, ?string $street2 = null): Address
    {
        $default_address = $user->defaultAddress();
        if (null === $default_address) {
            $address = CreateAddress::make()->handle($name, $street1, $city, $state, $zip, $country, $street2);
        } else {
            $address = UpdateAddress::make()->handle($default_address, $name, $street1, $city, $state, $zip, $country, $street2);
        }

        $user->setDefaultAddress($address);
        UserUpdatedEvent::dispatch($user);

        return $address;
    }

    public function asController(User $user): JsonResponse
    {
        request()->user()->canUpdateUserAddresses($user, true);

        $this->handle(
            user: $user,
            name: request()->input('name'),
            street1: request()->input('street1'),
            city: request()->input('city'),
            state: request()->input('state'),
            zip: request()->input('zip'),
            country: request()->input('country'),
            street2: request()->input('street2'),
        );

        return response()->json($user->defaultAddress()->toArray(), 200);
    }

    public function rules(): array
    {
        if (null === request()->user()->defaultAddress()) {
            return CreateAddress::make()->rules();
        }

        return UpdateAddress::make()->rules();
    }
}
