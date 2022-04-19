<?php

declare(strict_types=1);

use App\Auth\Actions\Logout;
use App\Support\Actions\GetApiDocumentation;
use App\Support\Enum\RouteEnum;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])
    ->group(function (): void {
        Route::get('api/documentation', GetApiDocumentation::class)
            ->name(RouteEnum::API_DOCUMENTATION->value)
        ;
    })
;

Route::prefix('auth')
    ->group(function (): void {
        Route::get('logout', Logout::class)
            ->name(RouteEnum::AUTH_LOGOUT->value)
        ;
    })
;
