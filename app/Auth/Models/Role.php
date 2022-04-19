<?php

declare(strict_types=1);

namespace App\Auth\Models;

use App\Users\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * App\Auth\Models\Role.
 *
 * @property int                                      $id
 * @property string                                   $name
 * @property string                                   $guard_name
 * @property null|Carbon                              $created_at
 * @property null|Carbon                              $updated_at
 * @property \App\Auth\Models\Permission[]|Collection $permissions
 * @property null|int                                 $permissions_count
 * @property Collection|User[]                        $users
 * @property null|int                                 $users_count
 *
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Role extends SpatieRole
{
    protected $with = ['permissions'];

    #[ArrayShape(['id' => 'int', 'name' => 'string', 'permissions' => '\\App\\Models\\Support\\Permission[]|\\Illuminate\\Database\\Eloquent\\Collection'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => $this->permissions,
        ];
    }
}
