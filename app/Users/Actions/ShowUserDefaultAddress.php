<?php

declare(strict_types=1);

namespace App\Users\Actions;

use App\Locations\Models\Address;
use App\Users\Models\User;
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
