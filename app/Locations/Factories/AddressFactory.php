<?php

declare(strict_types=1);

namespace Database\Factories\Locations\Models;

use App\Locations\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    #[ArrayShape(['name' => 'string', 'street1' => 'string', 'street2' => 'null', 'city' => 'string', 'state' => 'string', 'zip' => 'string', 'country' => 'string'])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'street1' => $this->faker->streetAddress(),
            'street2' => null,
            'city' => $this->faker->city(),
            'state' => 'CA',
            'zip' => $this->faker->postcode(),
            'country' => 'US',
        ];
    }
}
