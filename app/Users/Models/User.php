<?php

declare(strict_types=1);

namespace App\Users\Models;

use App\Auth\Models\Permission;
use App\Auth\Models\PersonalAccessToken;
use App\Auth\Models\Role;
use App\Locations\Models\Address;
use App\Locations\Traits\HasAddresses;
use App\Users\Builders\UserBuilder;
use App\Users\Traits\HasAppPermissions;
use Database\Factories\UserFactory;
use Eloquent;
use Hash;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Users\Models\User.
 *
 * @property int                                                   $id
 * @property string                                                $first_name
 * @property string                                                $last_name
 * @property string                                                $email
 * @property null|string                                           $payments_id
 * @property null|Carbon                                           $email_verified_at
 * @property string                                                $password
 * @property null|string                                           $remember_token
 * @property null|Carbon                                           $created_at
 * @property null|Carbon                                           $updated_at
 * @property null|Carbon                                           $deleted_at
 * @property Address[]|Collection                                  $addresses
 * @property null|int                                              $addresses_count
 * @property DatabaseNotification[]|DatabaseNotificationCollection $notifications
 * @property null|int                                              $notifications_count
 * @property Collection|Permission[]                               $permissions
 * @property null|int                                              $permissions_count
 * @property Collection|Role[]                                     $roles
 * @property null|int                                              $roles_count
 * @property Collection|PersonalAccessToken[]                      $tokens
 * @property null|int                                              $tokens_count
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static UserBuilder|User newModelQuery()
 * @method static UserBuilder|User newQuery()
 * @method static QueryBuilder|User onlyTrashed()
 * @method static UserBuilder|User permission($permissions)
 * @method static UserBuilder|User query()
 * @method static UserBuilder|User role($roles, $guard = null)
 * @method static UserBuilder|User whereCreatedAt($value)
 * @method static UserBuilder|User whereDeletedAt($value)
 * @method static UserBuilder|User whereEmail($value)
 * @method static UserBuilder|User whereEmailVerifiedAt($value)
 * @method static UserBuilder|User whereFirstName($value)
 * @method static UserBuilder|User whereId($value)
 * @method static UserBuilder|User whereLastName($value)
 * @method static UserBuilder|User wherePassword($value)
 * @method static UserBuilder|User wherePaymentsId($value)
 * @method static UserBuilder|User whereRememberToken($value)
 * @method static UserBuilder|User whereUpdatedAt($value)
 * @method static QueryBuilder|User withTrashed()
 * @method static QueryBuilder|User withoutTrashed()
 * @mixin Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasAddresses;
    use HasApiTokens;
    use HasAppPermissions;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /** @var array<string, string> */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /** @param QueryBuilder $query */
    #[Pure]
    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }

    public function newPasswordEquals(string $new_password): bool
    {
        return Hash::check($new_password, $this->password);
    }

    public function setPassword(string $password): void
    {
        $this->password = Hash::make($password);
    }

    #[ArrayShape(['id' => 'int', 'first_name' => 'string', 'last_name' => 'string', 'email' => 'string'])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ];
    }

    #[ArrayShape(['id' => 'int', 'first_name' => 'string', 'last_name' => 'string', 'email' => 'string', 'permissions' => '\\Illuminate\\Support\\Collection', 'roles' => '\\App\\Models\\Support\\Role[]|\\Illuminate\\Database\\Eloquent\\Collection', 'meta' => 'array'])]
    public function authToArray(): array
    {
        $data = self::toArray();
        $data['meta'] = [
            'is_email_verified' => $this->hasVerifiedEmail(),
        ];
        $data['roles'] = $this->roles;
        $data['permissions'] = $this->permissions;

        return $data;
    }

    /** @codeCoverageIgnore */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
