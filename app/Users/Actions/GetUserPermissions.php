<?php

declare(strict_types=1);

namespace App\Users\Actions;

use App\Auth\Models\Permission;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserPermissions
{
    use AsAction;

    /** @return Collection|Permission[] */
    public function handle(User $user): Collection|array
    {
        return $user->permissions;
    }

    /** @return Collection|Permission[] */
    public function asController(User $user): Collection|array
    {
        request()->user()->canViewUserPermissions($user, true);

        return $this->handle($user);
    }
}
