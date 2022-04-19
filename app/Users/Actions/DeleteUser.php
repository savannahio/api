<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeleteUser
{
    use AsAction;

    public function handle(User $user): void
    {
        $user->addresses()->delete();
        $user->delete();
    }

    #[Pure]
    public function asController(User $user): JsonResponse
    {
        $requesting_user = request()->user();
        $requesting_user->canDeleteUsers(true);
        if ($requesting_user->id === $user->id) {
            throw new BadRequestHttpException('Cannot delete your own user');
        }

        $this->handle($user);

        return response()->json(null, 204);
    }
}
