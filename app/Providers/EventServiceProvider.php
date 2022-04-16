<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\UserListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        UserListener::class,
    ];
}