<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Support\Enum\DirectionEnum;
use App\Models\Support\Traits\HasPaginatedInput;
use App\Models\Users\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUsers
{
    use AsAction;
    use HasPaginatedInput;

    public const DEFAULT_ORDER_BY = 'users.id';

    public function handle(?int $page = 1, ?int $per_page = 20, ?string $order_by = self::DEFAULT_ORDER_BY, ?DirectionEnum $direction = DirectionEnum::ASC): LengthAwarePaginator
    {
        $qb = User::query();
        $qb->orderBy($order_by, $direction->value);

        return $qb->paginate($per_page, ['users.*'], 'page', $page);
    }

    public function asController(): LengthAwarePaginator
    {
        request()->user()->canViewUsers(true);

        return $this->handle(
            page: $this->getPageInput(),
            per_page: $this->getPerPageInput(),
            order_by: $this->getOrderBy(self::DEFAULT_ORDER_BY),
            direction: $this->getDirectionInput()
        );
    }

    public function rules(): array
    {
        return array_merge([
        ], $this->getPageValidationRules());
    }
}
