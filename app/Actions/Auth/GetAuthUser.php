<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\Users\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthUser
{
    use AsAction;

    public function handle(User $user): array
    {
        return $user->authToArray();
    }

    public function asController(): array
    {
        return $this->handle(
            request()->user(),
        );
    }
}
