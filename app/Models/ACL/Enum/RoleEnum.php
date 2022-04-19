<?php

declare(strict_types=1);

namespace App\Models\Support\Enum;

use App\Models\Support\Traits\HasEnumCases;

enum RoleEnum: string
{
    use HasEnumCases;

    case ADMIN = 'admin';

    case DEVELOPER = 'developer';

    case USER_MANAGEMENT = 'user management';

    case ROLE_MANAGEMENT = 'role management';

    case PERMISSION_MANAGEMENT = 'permission management';
}
