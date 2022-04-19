<?php

declare(strict_types=1);

namespace App\Actions\PersonalAccessTokens;

use App\Models\Support\Enum\DirectionEnum;
use App\Models\Support\Traits\HasPaginatedInput;
use App\Users\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPersonalAccessTokens
{
    use AsAction;
    use HasPaginatedInput;

    public function handle(User $user, ?int $page = 1, ?int $per_page = 20, ?DirectionEnum $direction = DirectionEnum::ASC): LengthAwarePaginator
    {
        $qb = $user->tokens();
        $qb->orderBy('personal_access_tokens.id', $direction->value);

        return $qb->paginate($per_page, ['*'], 'page', $page);
    }

    public function asController(): LengthAwarePaginator
    {
        return $this->handle(
            user: request()->user(),
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
