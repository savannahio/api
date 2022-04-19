<?php

declare(strict_types=1);

namespace App\Actions\PersonalAccessTokens;

use App\Models\Users\PersonalAccessToken;
use App\Users\Models\User;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Lorisleiva\Actions\Concerns\AsAction;

class DeletePersonalAccessToken
{
    use AsAction;

    public function handle(User $user, PersonalAccessToken $personal_access_token): void
    {
        $user->tokens()->getQuery()->findOrFail($personal_access_token->id);
        $personal_access_token->delete();
    }

    #[Pure]
    public function asController(PersonalAccessToken $personal_access_token): JsonResponse
    {
        $this->handle(
            user: request()->user(),
            personal_access_token: $personal_access_token,
        );

        return response()->json(null, 204);
    }
}
