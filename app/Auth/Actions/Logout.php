<?php

declare(strict_types=1);

namespace App\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;
use Session;

class Logout
{
    use AsAction;

    public function handle(): void
    {
        Session::flush();
        Auth::logout();
    }

    public function asController(): void
    {
        $this->handle();
    }
}
