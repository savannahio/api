<?php

declare(strict_types=1);

namespace App\Models\Support;

use App\Models\Users\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * App\Models\Support\Role.
 *
 * @property int                                         $id
 * @property string                                      $name
 * @property string                                      $guard_name
 * @property null|Carbon                                 $created_at
 * @property null|Carbon                                 $updated_at
 * @property \App\Models\Support\Permission[]|Collection $permissions
 * @property null|int                                    $permissions_count
 * @property Collection|User[]                           $users
 * @property null|int                                    $users_count
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
    #[ArrayShape(['id' => 'int', 'name' => '\\App\\Models\\Support\\Enum\\PermissionEnum'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
