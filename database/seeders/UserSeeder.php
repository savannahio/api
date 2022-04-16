<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Actions\Users\CreateUser;
use App\Models\Support\Enum\RoleEnum;
use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $super_user_roles = [
            RoleEnum::ADMIN->value,
            RoleEnum::DEVELOPER->value,
            RoleEnum::USER_MANAGEMENT->value,
            RoleEnum::ROLE_MANAGEMENT->value,
            RoleEnum::PERMISSION_MANAGEMENT->value,
        ];

        CreateUser::make()->handle(
            first_name: 'James',
            last_name: 'Weston',
            email: 'jamesvweston@gmail.com',
            password: 'password',
            roles: $super_user_roles
        );

        foreach (User::factory(10)->make() as $user) {
            CreateUser::make()->handle(
                first_name: $user->first_name,
                last_name: $user->last_name,
                email: $user->email,
                password: 'password',
            );
        }
    }
}
