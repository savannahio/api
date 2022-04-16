<?php

declare(strict_types=1);

namespace App\Actions\Web;

use Cache;
use File;
use Lorisleiva\Actions\Concerns\AsAction;

class GetApiDocumentation
{
    use AsAction;

    public function handle(): string
    {
        return Cache::remember(
            key: 'api.documentation',
            ttl: 1000,
            callback: fn () => File::get(public_path('documentation/api_documentation.html'))
        );

    }

    public function asController(): string
    {
        return $this->handle();
    }
}
