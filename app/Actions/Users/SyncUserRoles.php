<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Support\Enum\RoleEnum;
use App\Models\Support\Role;
use App\Models\Users\User;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncUserRoles
{
    use AsAction;

    /**
     * @param array<string> $roles
     *
     * @return Collection|Role[]
     */
    public function handle(User $user, array $roles): Collection|array
    {
        $user->syncRoles($roles);

        return $user->roles;
    }

    public function asController(User $user): Collection|array
    {
        request()->user()->canUpdateUserRoles($user, true);

        return $this->handle(
            user: $user,
            roles: request()->input('roles')
        );
    }

    public function rules(): array
    {
        return [
            'roles' => 'required|array',
            'roles.*' => ['required', 'string', 'distinct', Rule::in(RoleEnum::values())],
        ];
    }
}
