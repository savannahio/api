<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\ACL\Enum\PermissionEnum;
use App\Models\ACL\Permission;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class SyncUserPermissions
{
    use AsAction;

    /**
     * @param array<string> $permissions
     *
     * @return Collection|Permission[]
     */
    public function handle(User $user, array $permissions): Collection|array
    {
        $user->syncPermissions($permissions);

        return $user->permissions;
    }

    public function asController(User $user): Collection|array
    {
        request()->user()->canUpdateUserPermissions(true);

        return $this->handle(
            user: $user,
            permissions: request()->input('permissions')
        );
    }

    public function rules(): array
    {
        return [
            'permissions' => 'required|array',
            'permissions.*' => ['required', 'string', 'distinct', Rule::in(PermissionEnum::values())],
        ];
    }
}
