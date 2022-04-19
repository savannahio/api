<?php

declare(strict_types=1);

namespace App\Models\Support\Enum;

use App\Models\Support\Traits\HasEnumCases;

enum MorphMapEnum: int
{
    use HasEnumCases;

    case USER = 1;

    case PERMISSION = 2;

    case ROLE = 3;
}
