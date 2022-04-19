<?php

declare(strict_types=1);

namespace App\Users\Actions;

use App\Auth\Enum\PermissionEnum;
use App\Auth\Enum\RoleEnum;
use App\Users\Events\UserRegisteredEvent;
use App\Users\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    public string $commandSignature = 'users:create {first_name} {last_name} {email} {password} ';
    public string $commandDescription = 'Creates a User';

    /**
     * @param null|array<string> $roles
     * @param null|array<string> $permissions
     */
    public function handle(string $first_name, string $last_name, string $email, string $password, ?array $roles = null, ?array $permissions = null): User
    {
        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = Str::lower($email);
        $user->setPassword($password);
        $user->save();

        if (null !== $roles) {
            $user->syncRoles($roles);
        }

        if (null !== $permissions) {
            $user->syncPermissions($permissions);
        }

        UserRegisteredEvent::dispatch($user);

        return $user;
    }

    public function asCommand(Command $command): void
    {
        $this->handle(
            first_name: $command->argument('first_name'),
            last_name: $command->argument('last_name'),
            email: $command->argument('email'),
            password: $command->argument('password'),
        );

        $command->line('Done!');
    }

    public function asController(): User
    {
        return $this->handle(
            first_name: request()->input('first_name'),
            last_name: request()->input('last_name'),
            email: request()->input('email'),
            password: request()->input('password'),
            roles: request()->input('roles'),
            permissions: request()->input('permissions'),
        );
    }

    #[ArrayShape(['first_name' => 'string[]', 'last_name' => 'string[]', 'email' => 'array', 'password' => 'string[]', 'roles' => 'array', 'permissions' => 'array'])]
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2'],
            'last_name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', 'confirmed', 'string', 'min:6'],
            'roles' => ['nullable', Rule::in(RoleEnum::values())],
            'permissions' => ['nullable', Rule::in(PermissionEnum::values())],
        ];
    }
}
