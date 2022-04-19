<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Support\Address;
use App\Models\Users\User;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\Pure;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowUserDefaultAddress
{
    use AsAction;

    public function handle(User $user): ?Address
    {
        return $user->defaultAddress();
    }

    #[Pure]
    public function asController(User $user): JsonResponse
    {
        request()->user()->canViewUserAddresses($user, true);
        $default_address = $this->handle($user);
        if (null !== $default_address) {
            return response()->json($user->defaultAddress()->toArray());
        }

        return response()->json([]);
    }
}
