<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Users\User;
use Illuminate\Auth\Events\Verified;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VerifyEmail
{
    use AsAction;

    public function handle(User $user): User
    {
        if ($user->hasVerifiedEmail()) {
            throw new BadRequestHttpException('Email has already been verified');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return $user;
    }

    public function asController(): User
    {
        $user = User::findOrFail(request()->route('id'));
        $user->sendEmailVerificationNotification();

        return $this->handle($user);
    }
}
