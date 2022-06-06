<?php

declare(strict_types=1);

use App\Actions\Auth\Logout;
use App\Actions\Users\VerifyEmail;
use App\Actions\Web\GetApiDocumentation;
use App\Models\Support\Enum\RouteEnum;
use Illuminate\Support\Facades\Route;

Route::middleware(['signed', 'throttle:6,1'])
    ->get('/email/verify/{id}/{hash}', VerifyEmail::class)
    ->name(RouteEnum::EMAIL_VERIFICATION->value)
;

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
