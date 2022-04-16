<?php

declare(strict_types=1);

namespace App\Models\Support\Enum;

use App\Models\Support\Traits\HasEnumCases;

enum PermissionEnum: string
{
    use HasEnumCases;

    case CREATE_USERS = 'create users';

    case UPDATE_USERS = 'update users';

    case DELETE_USERS = 'delete users';

    case SHOW_USERS = 'show users';

    case VIEW_USERS = 'view users';

    case VIEW_ROLES = 'view roles';

    case VIEW_PERMISSIONS = 'view permissions';

    case VIEW_USER_ROLES = 'view user roles';

    case UPDATE_USER_ROLES = 'update user roles';

    case VIEW_USER_PERMISSIONS = 'view user permissions';

    case UPDATE_USER_PERMISSIONS = 'update user permissions';
}
