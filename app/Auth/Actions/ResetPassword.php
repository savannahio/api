<?php

declare(strict_types=1);

namespace App\Auth\Actions;

use App\Users\Events\ResetPasswordEvent;
use App\Users\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ResetPassword
{
    use AsAction;

    public function handle(User $user, string $password): void
    {
        if (!$user->newPasswordEquals($password)) {
            $user->setPassword($password);
            $user->save();
            ResetPasswordEvent::dispatch($user);
        }
    }

    public function asController(): void
    {
        $this->handle(
            user: request()->user(),
            password: request()->input('new_password')
        );
    }

    public function rules(): array
    {
        return [
            'new_password' => ['required', 'confirmed', 'string', 'min:6'],
        ];
    }
}
