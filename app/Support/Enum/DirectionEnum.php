<?php

declare(strict_types=1);

namespace App\Models\Support\Enum;

use App\Models\Support\Traits\HasEnumCases;

enum DirectionEnum: string
{
    use HasEnumCases;

    case ASC = 'asc';

    case DESC = 'desc';
}
