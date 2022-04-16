<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Events\Users\ResetPasswordEvent;
use App\Models\Users\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ResetPassword
{
    use AsAction;

    public function handle(User $user, string $password): void
    {
        $user->setPassword($password);
        $user->save();
        event(new ResetPasswordEvent($user));
    }

    public function asController(): void
    {
        $this->handle(request()->user(), request()->input('new_password'));
    }

    public function rules(): array
    {
        return [
            'new_password' => ['required', 'confirmed', 'string', 'min:6'],
        ];
    }
}
