<?php

declare(strict_types=1);

namespace App\Support\Console;

use App\Users\Actions\CreateUser;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateUser::class,
    ];
}
