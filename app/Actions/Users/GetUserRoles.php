<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\Support\Enum\DirectionEnum;
use App\Models\Support\Traits\HasPaginatedInput;
use App\Models\Users\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserRoles
{
    use AsAction;
    use HasPaginatedInput;

    public function handle(User $user, ?int $page = 1, ?int $per_page = 20, ?DirectionEnum $direction = DirectionEnum::ASC): LengthAwarePaginator
    {
        $qb = $user->roles()->getQuery();
        $qb->orderBy('roles.id', $direction->value);

        return $qb->paginate($per_page, ['*'], 'page', $page);
    }

    public function asController(User $user): LengthAwarePaginator
    {
        request()->user()->canViewUserRoles($user, true);

        return $this->handle(
            user: $user,
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
