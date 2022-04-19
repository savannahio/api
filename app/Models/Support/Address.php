<?php

declare(strict_types=1);

namespace App\Models\Support;

use App\Models\Users\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\Support\Address.
 *
 * @property int                                             $id
 * @property string                                          $name
 * @property string                                          $street1
 * @property null|string                                     $street2
 * @property string                                          $city
 * @property string                                          $state
 * @property string                                          $zip
 * @property string                                          $country
 * @property null|Carbon                                     $created_at
 * @property null|Carbon                                     $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property null|int                                        $users_count
 *
 * @method static \Database\Factories\Support\AddressFactory factory(...$parameters)
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address query()
 * @method static Builder|Address whereCity($value)
 * @method static Builder|Address whereCountry($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereName($value)
 * @method static Builder|Address whereState($value)
 * @method static Builder|Address whereStreet1($value)
 * @method static Builder|Address whereStreet2($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereZip($value)
 * @mixin Eloquent
 */
class Address extends Model
{
    use HasFactory;

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'addressable');
    }

    #[ArrayShape(['id' => 'int', 'name' => 'string', 'street1' => 'string', 'street2' => 'null|string', 'city' => 'string', 'state' => 'string', 'zip' => 'string', 'country' => 'string'])]
    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'street1' => $this->street1,
            'street2' => $this->street2,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'country' => $this->country,
        ];

        if (isset($this->pivot, $this->pivot->is_default)) {
            $data['is_default'] = (bool) $this->pivot->is_default;
        }

        return $data;
    }
}
