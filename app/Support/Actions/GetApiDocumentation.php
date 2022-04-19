<?php

declare(strict_types=1);

namespace App\Support\Actions;

use App\Support\Enum\RouteEnum;
use Cache;
use File;
use Lorisleiva\Actions\Concerns\AsAction;

class GetApiDocumentation
{
    use AsAction;

    public function handle(): string
    {
        return Cache::remember(
            key: RouteEnum::API_DOCUMENTATION->value,
            ttl: 1000,
            callback: fn () => File::get(public_path('documentation/api_documentation.html'))
        );
    }

    public function asController(): string
    {
        request()->user()->canViewApiDocumentation(true);

        return $this->handle();
    }
}
