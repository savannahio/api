<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Login
{
    use AsAction;

    public function handle(string $email, string $password): void
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            request()->session()->regenerate();

            return;
        }

        throw new UnauthorizedHttpException('Invalid credentials');
    }

    public function asController(): void
    {
        $this->handle(
            request()->input('email'),
            request()->input('password')
        );
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
