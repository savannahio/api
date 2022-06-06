<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Events\Users\UserRolesUpdatedEvent;
use App\Models\ACL\Enum\RoleEnum;
use App\Models\ACL\Role;
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
        UserRolesUpdatedEvent::dispatch($user);
        return $user->roles;
    }

    public function asController(User $user): Collection|array
    {
        request()->user()->canUpdateUserRoles(true);

        return $this->handle(
            user: $user,
            roles: request()->input('roles')
        );
    }

    public function rules(): array
    {
        return [
            'roles' => ['present', 'array'],
            'roles.*' => ['required', 'string', 'distinct', Rule::in(RoleEnum::values())],
        ];
    }
}
