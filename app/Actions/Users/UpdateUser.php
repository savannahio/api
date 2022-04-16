<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Events\Users\UserUpdatedEmailEvent;
use App\Models\Users\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUser
{
    use AsAction;

    public function handle(User $user, ?string $first_name = null, ?string $last_name = null, ?string $email = null): User
    {
        $updating_email = Str::lower($user->email) !== Str::lower($email);

        if (null !== $first_name) {
            $user->first_name = $first_name;
        }

        if (null !== $last_name) {
            $user->last_name = $last_name;
        }

        if (null !== $email && $updating_email) {
            $user->email_verified_at = null;
            $user->email = Str::lower($email);
        }

        $user->save();

        if ($updating_email) {
            event(new UserUpdatedEmailEvent($user));
        }

        return $user;
    }

    public function asController(User $user): User
    {
        request()->user()->canUpdateUser($user, true);

        return $this->handle(
            user: $user,
            first_name: request()->input('first_name'),
            last_name: request()->input('last_name'),
            email: request()->input('email'),
        );
    }

    #[ArrayShape(['first_name' => 'string[]', 'last_name' => 'string[]', 'email' => 'array'])]
    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string', 'min:2'],
            'last_name' => ['nullable', 'string', 'min:2'],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore(request()->route('user')->id)],
        ];
    }
}
