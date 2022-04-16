<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Support\Enum\PermissionEnum;
use App\Models\Support\Enum\RoleEnum;
use App\Models\Support\Permission;
use App\Models\Support\Role;
use Illuminate\Database\Seeder;

class ACLSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionEnum::cases() as $item) {
            Permission::create(['name' => $item]);
        }

        foreach (RoleEnum::cases() as $item) {
            Role::create(['name' => $item]);
        }

        $user_management = Role::findByName(RoleEnum::USER_MANAGEMENT->value);
        $user_management->syncPermissions([
            PermissionEnum::CREATE_USERS->value,
            PermissionEnum::UPDATE_USERS->value,
            PermissionEnum::DELETE_USERS->value,
            PermissionEnum::SHOW_USERS->value,
            PermissionEnum::VIEW_USERS->value,

            PermissionEnum::VIEW_USER_ROLES->value,
            PermissionEnum::UPDATE_USER_ROLES->value,

            PermissionEnum::VIEW_USER_PERMISSIONS->value,
            PermissionEnum::UPDATE_USER_PERMISSIONS->value,
        ]);

        $role_management = Role::findByName(RoleEnum::ROLE_MANAGEMENT->value);
        $role_management->syncPermissions([
            PermissionEnum::VIEW_ROLES->value,
        ]);

        $permission_management = Role::findByName(RoleEnum::PERMISSION_MANAGEMENT->value);
        $permission_management->syncPermissions([
            PermissionEnum::VIEW_PERMISSIONS->value,
        ]);
    }
}
