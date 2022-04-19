<?php

declare(strict_types=1);

namespace Database\Factories\Users\Models;

use App\Users\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class UserFactory extends Factory
{
    protected $model = User::class;

    #[ArrayShape(['first_name' => 'string', 'last_name' => 'string', 'email' => 'string', 'email_verified_at' => '\\Illuminate\\Support\\Carbon', 'password' => 'string', 'remember_token' => 'string'])]
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make($this->faker->password),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
