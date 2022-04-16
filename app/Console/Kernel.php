<?php

declare(strict_types=1);

namespace App\Console;

use App\Actions\Users\CreateUser;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateUser::class,
    ];
}
