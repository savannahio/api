<?php

declare(strict_types=1);

namespace App\Users\Actions;

use App\Auth\Models\Role;
use App\Users\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserRoles
{
    use AsAction;

    /** @return Collection|Role[] */
    public function handle(User $user): Collection|array
    {
        return $user->roles;
    }

    /** @return Collection|Role[] */
    public function asController(User $user): Collection|array
    {
        request()->user()->canViewUserRoles($user, true);

        return $this->handle(user: $user);
    }
}
