<?php

declare(strict_types=1);

namespace App\Actions\Support;

use App\Models\Support\Address;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAddress
{
    use AsAction;

    public function handle(Address $address, string $name, string $street1, string $city, string $state, string $zip, string $country, ?string $street2 = null): Address
    {
        $address->name = $name;
        $address->street1 = $street1;
        $address->street2 = $street2;
        $address->city = $city;
        $address->state = $state;
        $address->zip = $zip;
        $address->country = $country;

        $address->save();

        return $address;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5'],
            'street1' => ['required', 'string', 'min:5'],
            'city' => ['required', 'string', 'min:2'],
            'state' => ['required', 'string', 'min:2'],
            'zip' => ['required', 'string', 'min:5'],
            'country' => ['required', 'string', 'min:2'],
            'street2' => ['nullable', 'string', 'min:2'],
        ];
    }
}
