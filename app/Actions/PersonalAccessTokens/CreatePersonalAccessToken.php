<?php

declare(strict_types=1);

namespace App\Actions\PersonalAccessTokens;

use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Laravel\Sanctum\NewAccessToken;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePersonalAccessToken
{
    use AsAction;

    public function handle(User $user, string $name): NewAccessToken
    {
        return $user->createToken($name);
    }

    #[Pure]
    public function asController(): JsonResponse
    {
        $token = $this->handle(
            user: request()->user(),
            name: request()->input('name'),
        );

        return response()->json($token, 201);
    }

    #[ArrayShape(['name' => 'string[]'])]
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2'],
        ];
    }
}
