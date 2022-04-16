<?php

declare(strict_types=1);

namespace App\Actions\ACL;

use App\Models\Support\Enum\DirectionEnum;
use App\Models\Support\Role;
use App\Models\Support\Traits\HasPaginatedInput;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRoles
{
    use AsAction;
    use HasPaginatedInput;

    public function handle(?int $page = 1, ?int $per_page = 20, ?DirectionEnum $direction = DirectionEnum::ASC): LengthAwarePaginator
    {
        $qb = Role::query();
        $qb->orderBy('roles.id', $direction->value);

        return $qb->paginate($per_page, ['*'], 'page', $page);
    }

    public function asController(): LengthAwarePaginator
    {
        request()->user()->canViewRoles(true);

        return $this->handle(
            page: $this->getPageInput(),
            per_page: $this->getPerPageInput(),
            direction: $this->getDirectionInput()
        );
    }

    public function rules(): array
    {
        return [
            ...$this->getPageValidationRules(),
        ];
    }
}
