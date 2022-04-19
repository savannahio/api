<?php

declare(strict_types=1);

namespace App\Users\Actions;

use App\Users\Events\UserUpdatedEmailEvent;
use App\Users\Events\UserUpdatedEvent;
use App\Users\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUser
{
    use AsAction;

    public function handle(User $user, ?string $first_name = null, ?string $last_name = null, ?string $email = null): User
    {
        $updating_first_name = !(null === $first_name) && $user->first_name !== $first_name;
        $updating_last_name = !(null === $last_name) && $user->last_name !== $last_name;
        $updating_email = !(null === $email) && $user->email !== $email;
        $setting_new_email = !(null === $email) && Str::lower($user->email) !== Str::lower($email);

        if ($updating_first_name) {
            $user->first_name = $first_name;
        }

        if ($updating_last_name) {
            $user->last_name = $last_name;
        }

        if ($updating_email) {
            $user->email = Str::lower($email);
        }

        if ($setting_new_email) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($updating_first_name || $updating_last_name || $updating_email) {
            UserUpdatedEvent::dispatch($user);
        }

        if ($setting_new_email) {
            UserUpdatedEmailEvent::dispatch($user);
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
