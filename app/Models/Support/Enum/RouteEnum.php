<?php

declare(strict_types=1);

namespace App\Models\Support\Enum;

enum RouteEnum: string
{
    case ACCESS_TOKENS_LIST = 'access_tokens.list';

    case ACCESS_TOKENS_CREATE = 'access_tokens.create';

    case ACCESS_TOKENS_DELETE = 'access_tokens.delete';

    case API_DOCUMENTATION = 'api.documentation';

    case EMAIL_VERIFICATION = 'verification.verify';

    case EMAIL_VERIFICATION_RESEND = 'verification.send';

    case AUTH_LOGIN = 'auth.login';

    case AUTH_LOGOUT = 'auth.logout';

    case AUTH_RESET_PASSWORD = 'auth.reset_password';

    case PERMISSIONS_LIST = 'permissions.list';

    case ROLES_LIST = 'roles.list';

    case USERS_CREATE = 'users.create';

    case USERS_ME = 'users.me';

    case USERS_LIST = 'users.list';

    case USERS_SHOW = 'users.show';

    case USERS_UPDATE = 'users.update';

    case USERS_ROLES_LIST = 'users.roles.list';

    case USERS_ROLES_UPDATE = 'users.roles.update';

    case USERS_PERMISSIONS_LIST = 'users.permissions.list';

    case USERS_PERMISSIONS_UPDATE = 'users.permissions.update';
}
