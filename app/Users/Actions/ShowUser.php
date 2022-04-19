<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Users\User;
use JetBrains\PhpStorm\Pure;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowUser
{
    use AsAction;

    public function handle(User $user): User
    {
        return $user;
    }

    #[Pure]
    public function asController(User $user): User
    {
        request()->user()->canShowUsers($user, true);

        return $this->handle(
            $user,
        );
    }
}
