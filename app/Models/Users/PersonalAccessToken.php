<?php

declare(strict_types=1);

namespace App\Models\Users;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * App\Models\Users\PersonalAccessToken.
 *
 * @property int            $id
 * @property string         $tokenable_type
 * @property int            $tokenable_id
 * @property string         $name
 * @property string         $token
 * @property null|array     $abilities
 * @property null|Carbon    $last_used_at
 * @property null|Carbon    $created_at
 * @property null|Carbon    $updated_at
 * @property Eloquent|Model $tokenable
 *
 * @method static Builder|PersonalAccessToken newModelQuery()
 * @method static Builder|PersonalAccessToken newQuery()
 * @method static Builder|PersonalAccessToken query()
 * @method static Builder|PersonalAccessToken whereAbilities($value)
 * @method static Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static Builder|PersonalAccessToken whereId($value)
 * @method static Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static Builder|PersonalAccessToken whereName($value)
 * @method static Builder|PersonalAccessToken whereToken($value)
 * @method static Builder|PersonalAccessToken whereTokenableId($value)
 * @method static Builder|PersonalAccessToken whereTokenableType($value)
 * @method static Builder|PersonalAccessToken whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{
    #[ArrayShape(['id' => 'int', 'name' => 'string', 'created_at' => '\\Illuminate\\Support\\Carbon|null', 'updated_at' => '\\Illuminate\\Support\\Carbon|null'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
