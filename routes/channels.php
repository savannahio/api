<?php

declare(strict_types=1);

use App\Models\Users\User;

Broadcast::channel('users.{userId}', function (User $user, int $userId) {
    $request = User::whereid($userId)->firstOrFail();
    return $user->id === $request->id;
});