<?php

declare(strict_types=1);

namespace App\ACL\Actions;

use App\Models\ACL\Permission;
use App\Models\Support\Enum\DirectionEnum;
use App\Models\Support\Traits\HasPaginatedInput;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPermissions
{
    use AsAction;
    use HasPaginatedInput;

    public function handle(?int $page = 1, ?int $per_page = 20, ?DirectionEnum $direction = DirectionEnum::ASC): LengthAwarePaginator
    {
        $qb = Permission::query();
        $qb->orderBy('permissions.id', $direction->value);

        return $qb->paginate($per_page, ['*'], 'page', $page);
    }

    /** @return LengthAwarePaginator<Permission> */
    public function asController(): LengthAwarePaginator
    {
        request()->user()->canViewPermissions(true);

        return $this->handle(
            page: $this->getPageInput(),
            per_page: $this->getPerPageInput(),
            direction: $this->getDirectionInput()
        );
    }

    public function rules(): array
    {
        return array_merge([
        ], $this->getPageValidationRules());
    }
}
