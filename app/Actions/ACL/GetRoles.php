<?php

declare(strict_types=1);

namespace App\Actions\ACL;

use App\Models\ACL\Role;
use App\Models\Support\Enum\DirectionEnum;
use App\Models\Support\Traits\HasPaginatedInput;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetRoles
{
    use AsAction;
    use HasPaginatedInput;

    public const DEFAULT_ORDER_BY = 'roles.id';

    public function handle(?int $page = 1, ?int $per_page = 20, ?DirectionEnum $direction = DirectionEnum::ASC, string $order_by = self::DEFAULT_ORDER_BY): LengthAwarePaginator
    {
        $qb = Role::query();
        $qb->orderBy($order_by, $direction->value);

        return $qb->paginate($per_page, ['*'], 'page', $page);
    }

    public function asController(): LengthAwarePaginator
    {
        request()->user()->canViewRoles(true);

        return $this->handle(
            page: $this->getPageInput(),
            per_page: $this->getPerPageInput(),
            direction: $this->getDirectionInput(),
            order_by: $this->getOrderBy(self::DEFAULT_ORDER_BY),
        );
    }

    public function rules(): array
    {
        return array_merge([
        ], $this->getPageValidationRules([self::DEFAULT_ORDER_BY]));
    }
}
