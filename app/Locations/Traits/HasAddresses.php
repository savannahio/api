<?php

declare(strict_types=1);

namespace App\Locations\Traits;

use App\Locations\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property Address[]|Collection $addresses
 * @property null|int             $addresses_count
 */
trait HasAddresses
{
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable')->withPivot('is_default');
    }

    public function hasAddress(Address $address): bool
    {
        return (bool) $this->addresses()->where('id', '=', $address->id)->count();
    }

    public function defaultAddress(): ?Address
    {
        return $this->addresses()->wherePivot('is_default', true)->first();
    }

    public function setDefaultAddress(Address $address): Address
    {
        $exists = false;
        foreach ($this->addresses()->get() as $item) {
            $pivot_data = ['is_default' => false];
            if ($item->id === $address->id) {
                $exists = true;
                $pivot_data = ['is_default' => true];
            }
            $this->addresses()->updateExistingPivot($item->id, $pivot_data);
        }
        if (!$exists) {
            $this->addresses()->attach($address->id, ['is_default' => true]);
        }

        return $address;
    }
}
