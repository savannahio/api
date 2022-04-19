<?php

declare(strict_types=1);

namespace App\Models\Support\Traits;

use App\Models\Support\Enum\DirectionEnum;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

trait HasPaginatedInput
{
    #[ArrayShape(['page' => 'string[]', 'per_page' => 'string[]', 'direction' => 'array', 'order_by' => 'array'])]
    public function getPageValidationRules(?array $order_by = null): array
    {
        $rules = [
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
            'direction' => ['nullable', Rule::in(DirectionEnum::values())],
        ];

        if (null !== $order_by) {
            $rules['order_by'] = ['nullable', Rule::in($order_by)];
        }

        return $rules;
    }

    private function getPageInput(): ?int
    {
        return request()->input('page') ? (int) (request()->input('page')) : null;
    }

    private function getPerPageInput(): ?int
    {
        return request()->input('per_page') ? (int) (request()->input('per_page')) : null;
    }

    private function getOrderBy(string $default): string
    {
        return request()->input('order_by', $default);
    }

    private function getDirectionInput(): ?DirectionEnum
    {
        return DirectionEnum::tryFrom(request()->input('direction', DirectionEnum::ASC->value));
    }
}
