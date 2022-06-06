<?php

declare(strict_types=1);

namespace App\Actions\Web;

use App\Models\Support\Enum\RouteEnum;
use Cache;
use File;
use Lorisleiva\Actions\Concerns\AsAction;

class GetApiDocumentation
{
    use AsAction;

    public function handle(): string
    {
        return File::get(public_path('documentation/api_documentation.html'));
    }

    public function asController(): string
    {
        request()->user()->canViewApiDocumentation(true);

        return $this->handle();
    }
}
