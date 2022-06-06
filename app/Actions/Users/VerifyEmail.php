<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Events\Users\UserVerifiedEmailEvent;
use App\Models\Users\User;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Config;

class VerifyEmail
{
    use AsAction;

    public function handle(User $user): User
    {
        if ($user->hasVerifiedEmail()) {
            throw new BadRequestHttpException('Email has already been verified');
        }

        $user->markEmailAsVerified();
        UserVerifiedEmailEvent::dispatch($user);

        return $user;
    }

    public function asController(): RedirectResponse|User
    {
        $user = User::findOrFail(request()->route('id'));
        $this->handle($user);
        if (request()->expectsJson()) {
            return $user;
        }
        return redirect(Config::get('app.ui_url'));
    }
}
