<?php

declare(strict_types=1);

use App\Auth\Actions\CreatePersonalAccessToken;
use App\Auth\Actions\DeletePersonalAccessToken;
use App\Auth\Actions\GetAuthUser;
use App\Auth\Actions\GetPermissions;
use App\Auth\Actions\GetPersonalAccessTokens;
use App\Auth\Actions\GetRoles;
use App\Auth\Actions\Login;
use App\Auth\Actions\ResendVerificationEmail;
use App\Auth\Actions\ResetPassword;
use App\Support\Enum\RouteEnum;
use App\Users\Actions\CreateUser;
use App\Users\Actions\DeleteUser;
use App\Users\Actions\GetUserPermissions;
use App\Users\Actions\GetUserRoles;
use App\Users\Actions\GetUsers;
use App\Users\Actions\ShowUser;
use App\Users\Actions\ShowUserDefaultAddress;
use App\Users\Actions\SyncUserPermissions;
use App\Users\Actions\SyncUserRoles;
use App\Users\Actions\UpdateUser;
use App\Users\Actions\UpdateUserDefaultAddress;
use App\Users\Actions\VerifyEmail;
use Illuminate\Support\Facades\Route;

Route::middleware(['signed', 'throttle:6,1'])
    ->get('/email/verify/{id}/{hash}', VerifyEmail::class)
    ->name(RouteEnum::EMAIL_VERIFICATION->value)
;

Route::prefix('auth')
    ->group(function (): void {
        Route::post('login', Login::class)
            ->name(RouteEnum::AUTH_LOGIN->value)
        ;
    })
;

Route::prefix('users')
    ->group(function (): void {
        Route::post('', CreateUser::class)
            ->name(RouteEnum::USERS_CREATE->value)
        ;
    })
;

Route::middleware(['auth:sanctum'])
    ->group(function (): void {
        Route::post('/email/verify/resend', ResendVerificationEmail::class)
            ->name(RouteEnum::EMAIL_VERIFICATION_RESEND->value)
        ;

        Route::prefix('auth')
            ->group(function (): void {
                Route::post('reset_password', ResetPassword::class)
                    ->name(RouteEnum::AUTH_RESET_PASSWORD->value)
                ;
            })
        ;

        Route::prefix('roles')
            ->group(function (): void {
                Route::get('/', GetRoles::class)
                    ->name(RouteEnum::ROLES_LIST->value)
                ;
            })
        ;

        Route::prefix('permissions')
            ->group(function (): void {
                Route::get('/', GetPermissions::class)
                    ->name(RouteEnum::PERMISSIONS_LIST->value)
                ;
            })
        ;

        Route::prefix('access_tokens')
            ->group(function (): void {
                Route::get('', GetPersonalAccessTokens::class)
                    ->name(RouteEnum::ACCESS_TOKENS_LIST->value)
                ;
                Route::post('', CreatePersonalAccessToken::class)
                    ->name(RouteEnum::ACCESS_TOKENS_CREATE->value)
                ;

                Route::delete('{personal_access_token}', DeletePersonalAccessToken::class)
                    ->name(RouteEnum::ACCESS_TOKENS_DELETE->value)
                ;
            })
        ;

        Route::prefix('users')
            ->group(function (): void {
                Route::get('', GetUsers::class)
                    ->name(RouteEnum::USERS_LIST->value)
                ;
                Route::get('me', GetAuthUser::class)
                    ->name(RouteEnum::USERS_ME->value)
                ;

                Route::prefix('{user}')
                    ->group(function (): void {
                        Route::get('', ShowUser::class)
                            ->name(RouteEnum::USERS_SHOW->value)
                        ;
                        Route::put('', UpdateUser::class)
                            ->name(RouteEnum::USERS_UPDATE->value)
                        ;
                        Route::delete('', DeleteUser::class)
                            ->name(RouteEnum::USERS_DELETE->value)
                        ;

                        Route::prefix('default_address')
                            ->group(function (): void {
                                Route::get('', ShowUserDefaultAddress::class)
                                    ->name(RouteEnum::USERS_DEFAULT_ADDRESS_SHOW->value)
                                ;
                                Route::put('', UpdateUserDefaultAddress::class)
                                    ->name(RouteEnum::USERS_DEFAULT_ADDRESS_UPDATE->value)
                                ;
                            })
                        ;

                        Route::prefix('roles')
                            ->group(function (): void {
                                Route::get('', GetUserRoles::class)
                                    ->name(RouteEnum::USERS_ROLES_LIST->value)
                                ;
                                Route::put('', SyncUserRoles::class)
                                    ->name(RouteEnum::USERS_ROLES_UPDATE->value)
                                ;
                            })
                        ;

                        Route::prefix('permissions')
                            ->group(function (): void {
                                Route::get('', GetUserPermissions::class)
                                    ->name(RouteEnum::USERS_PERMISSIONS_LIST->value)
                                ;
                                Route::put('', SyncUserPermissions::class)
                                    ->name(RouteEnum::USERS_PERMISSIONS_UPDATE->value)
                                ;
                            })
                        ;
                    })
                ;
            })
    ;
    })
;
