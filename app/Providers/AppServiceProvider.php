<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\ACL\Permission;
use App\Models\ACL\Role;
use App\Models\Support\Enum\MorphMapEnum;
use App\Models\Users\PersonalAccessToken;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            MorphMapEnum::USER->value => User::class,
            MorphMapEnum::PERMISSION->value => Permission::class,
            MorphMapEnum::ROLE->value => Role::class,
        ]);

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        Sanctum::ignoreMigrations();
    }
}
