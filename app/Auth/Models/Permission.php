<?php

declare(strict_types=1);

namespace App\ACL\Models;

use App\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * App\Models\ACL\Permission.
 *
 * @property int                               $id
 * @property string                            $name
 * @property string                            $guard_name
 * @property null|Carbon                       $created_at
 * @property null|Carbon                       $updated_at
 * @property Collection|Permission[]           $permissions
 * @property null|int                          $permissions_count
 * @property \App\Models\ACL\Role[]|Collection $roles
 * @property null|int                          $roles_count
 * @property Collection|User[]                 $users
 * @property null|int                          $users_count
 *
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereGuardName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Permission extends SpatiePermission
{
    #[ArrayShape(['id' => 'int', 'name' => '\\App\\Models\\ACL\\Enum\\PermissionEnum'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
