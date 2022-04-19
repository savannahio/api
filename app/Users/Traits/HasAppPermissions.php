<?php

declare(strict_types=1);

namespace App\Users\Traits;

use App\Auth\Enum\PermissionEnum;
use App\Users\Models\User;
use Spatie\Permission\Exceptions\UnauthorizedException;

trait HasAppPermissions
{
    public function isUser(User $user): bool
    {
        return $this->id === $user->id;
    }

    public function canViewApiDocumentation($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::VIEW_API_DOCUMENTATION->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_API_DOCUMENTATION->value]);
        }

        return $condition;
    }

    public function canViewHorizon($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::VIEW_HORIZON->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_HORIZON->value]);
        }

        return $condition;
    }

    public function canViewTelescope($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::VIEW_TELESCOPE->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_TELESCOPE->value]);
        }

        return $condition;
    }

    public function canShowUsers(User $user, $throws = false): bool
    {
        $condition = $this->isUser($user);
        if (!$condition) {
            $condition = $this->hasPermissionTo(PermissionEnum::SHOW_USERS->value);
            if (!$condition && $throws) {
                throw UnauthorizedException::forPermissions([PermissionEnum::SHOW_USERS->value]);
            }
        }

        return $condition;
    }

    public function canDeleteUsers($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::DELETE_USERS->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::DELETE_USERS->value]);
        }

        return $condition;
    }

    public function canViewUsers($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::VIEW_USERS->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_USERS->value]);
        }

        return $condition;
    }

    public function canViewPermissions($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::VIEW_PERMISSIONS->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_PERMISSIONS->value]);
        }

        return $condition;
    }

    public function canViewRoles($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::VIEW_ROLES->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_ROLES->value]);
        }

        return $condition;
    }

    public function canViewUserAddresses(User $user, $throws = false): bool
    {
        $condition = $this->isUser($user);
        if (!$condition) {
            $condition = $this->hasPermissionTo(PermissionEnum::VIEW_USER_ADDRESSES->value);
            if (!$condition && $throws) {
                throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_USER_ADDRESSES->value]);
            }
        }

        return $condition;
    }

    public function canUpdateUserAddresses(User $user, $throws = false): bool
    {
        $condition = $this->isUser($user);
        if (!$condition) {
            $condition = $this->hasPermissionTo(PermissionEnum::UPDATE_USER_ADDRESSES->value);
            if (!$condition && $throws) {
                throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USER_ADDRESSES->value]);
            }
        }

        return $condition;
    }

    public function canViewUserPermissions(User $user, $throws = false): bool
    {
        $condition = $this->isUser($user);
        if (!$condition) {
            $condition = $this->hasPermissionTo(PermissionEnum::VIEW_USER_PERMISSIONS->value);
            if (!$condition && $throws) {
                throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_USER_PERMISSIONS->value]);
            }
        }

        return $condition;
    }

    public function canUpdateUserPermissions($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::UPDATE_USER_PERMISSIONS->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USER_PERMISSIONS->value]);
        }

        return $condition;
    }

    public function canViewUserRoles(User $user, $throws = false): bool
    {
        $condition = $this->isUser($user);
        if (!$condition) {
            $condition = $this->hasPermissionTo(PermissionEnum::VIEW_USER_ROLES->value);
            if (!$condition && $throws) {
                throw UnauthorizedException::forPermissions([PermissionEnum::VIEW_USER_ROLES->value]);
            }
        }

        return $condition;
    }

    public function canUpdateUserRoles($throws = false): bool
    {
        $condition = $this->hasPermissionTo(PermissionEnum::UPDATE_USER_ROLES->value);
        if (!$condition && $throws) {
            throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USER_ROLES->value]);
        }

        return $condition;
    }

    public function canUpdateUser(User $user, $throws = false): bool
    {
        $condition = $this->isUser($user);
        if (!$condition) {
            $condition = $this->hasPermissionTo(PermissionEnum::UPDATE_USERS->value);
            if (!$condition && $throws) {
                throw UnauthorizedException::forPermissions([PermissionEnum::UPDATE_USERS->value]);
            }
        }

        return $condition;
    }
}
