<?php

declare(strict_types=1);

namespace App\Support\Enum;

use App\Support\Traits\HasEnumCases;

enum MorphMapEnum: int
{
    use HasEnumCases;

    case USER = 1;

    case PERMISSION = 2;

    case ROLE = 3;
}
