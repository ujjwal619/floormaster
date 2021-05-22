<?php

namespace App\Data\Entities\Accessors\Customer;

/**
 * Trait CustomerAccessor
 * @package App\Data\Entities\Accessors\Customer
 */
/**
 * Trait CustomerAccessor
 * @package App\Data\Entities\Accessors\Customer
 */
/**
 * Trait CustomerAccessor
 * @package App\Data\Entities\Accessors\Customer
 */

use App\Data\Entities\Models\Customer\Customer;

/**
 * Trait CustomerAccessor
 * @package App\Data\Entities\Accessors\Customer
 */
trait CustomerAccessor
{
    /**
     * @return string
     */
    public function getFormattedAddressAttribute(): string
    {
        return $this->getFormattedAddress($this->address);
    }

    /**
     * Get the formatted address.
     * @param $address
     * @return string
     */
    public function getFormattedAddress($address): string
    {
        if (!$address) {
            return 'N/A';
        }
        return sprintf('%s, %s, %s, %s', $address->street, $address->town, $address->state, $address->code);
    }

    /**
     * @return string
     */
    public function getFormattedPostalAddressAttribute(): string
    {
        return $this->getFormattedAddress($this->postal_address);
    }

    /**
     * @return string
     */
    public function getFormattedDeliveryAddressAttribute(): string
    {
        /** @var Customer $this */
        return $this->getFormattedAddress($this->delivery_address);
    }
}