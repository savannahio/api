<?php

declare(strict_types=1);

namespace App\Models\Users\Traits;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Users\User;
use Spatie\Permission\Exceptions\UnauthorizedException;

trait HasAppPermissions
{
    public function isUser(User $user): bool
    {
        return $this->id === $user->id;
    }

    public function canShowUsers($throws = false): bool
    {
        $condition = !$this->hasPermissionTo(PermissionEnum::SHOW_USERS->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::SHOW_USERS->name]);
        }

        return $condition;
    }

    public function canViewUsers($throws = false): bool
    {
        $condition = !$this->hasPermissionTo(PermissionEnum::VIEW_USERS->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_USERS->name]);
        }

        return $condition;
    }

    public function canViewPermissions($throws = false): bool
    {
        $condition = !$this->hasPermissionTo(PermissionEnum::VIEW_PERMISSIONS->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_PERMISSIONS->name]);
        }

        return $condition;
    }

    public function canViewRoles($throws = false): bool
    {
        $condition = !$this->hasPermissionTo(PermissionEnum::VIEW_ROLES->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_ROLES->name]);
        }

        return $condition;
    }

    public function canViewUserPermissions(User $user, $throws = false): bool
    {
        $condition = !$this->isUser($user) && !$this->hasPermissionTo(PermissionEnum::UPDATE_USER_PERMISSIONS->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USER_PERMISSIONS->name]);
        }

        return $condition;
    }

    public function canViewUserRoles(User $user, $throws = false): bool
    {
        $condition = !$this->isUser($user) && !$this->hasPermissionTo(PermissionEnum::VIEW_USER_ROLES->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_USER_ROLES->name]);
        }

        return $condition;
    }

    public function canUpdateUserPermissions(User $user, $throws = false): bool
    {
        $condition = !$this->isUser($user) && !$this->hasPermissionTo(PermissionEnum::UPDATE_USER_PERMISSIONS->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USER_PERMISSIONS->name]);
        }

        return $condition;
    }

    public function canUpdateUserRoles(User $user, $throws = false): bool
    {
        $condition = !$this->isUser($user) && !$this->hasPermissionTo(PermissionEnum::UPDATE_USER_ROLES->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USER_ROLES->name]);
        }

        return $condition;
    }

    public function canUpdateUser(User $user, $throws = false): bool
    {
        $condition = !$this->isUser($user) && !$this->hasPermissionTo(PermissionEnum::UPDATE_USERS->value);
        if ($condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USERS->name]);
        }

        return $condition;
    }
}
