<?php

declare(strict_types=1);

namespace App\Support\Providers;

use App\Auth\Models\Permission;
use App\Auth\Models\PersonalAccessToken;
use App\Auth\Models\Role;
use App\Support\Enum\MorphMapEnum;
use App\Users\Models\User;
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
