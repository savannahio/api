<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\Users\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ResendVerificationEmail
{
    use AsAction;

    public function handle(User $user): void
    {
        if ($user->hasVerifiedEmail()) {
            throw new BadRequestHttpException('Email already verified');
        }
        $user->sendEmailVerificationNotification();
    }

    public function asController(): void
    {
        $this->handle(request()->user());
    }
}
