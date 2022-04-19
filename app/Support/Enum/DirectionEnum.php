<?php

declare(strict_types=1);

namespace App\Support\Enum;

use App\Support\Traits\HasEnumCases;

enum DirectionEnum: string
{
    use HasEnumCases;

    case ASC = 'asc';

    case DESC = 'desc';
}
