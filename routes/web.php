<?php

declare(strict_types=1);

use App\Actions\Auth\Logout;
use App\Actions\Web\GetApiDocumentation;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Support\Facades\Route;

Route::get('api/documentation', GetApiDocumentation::class)
    ->name(RouteEnum::API_DOCUMENTATION->value)
;

Route::prefix('auth')
    ->group(function (): void {
        Route::get('logout', Logout::class)
            ->name(RouteEnum::AUTH_LOGOUT->value)
        ;
    })
;
